<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Doutor;
use App\Models\Paciente;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Oauth2;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validação dos dados de entrada
        $request->validate([
            'cpf' => 'required|string',
            'password' => 'required|string',
        ]);

        // Removendo pontuação do CPF
        $cpf = preg_replace('/[^\d]/', '', $request->cpf);
        Log::info("Tentativa de login com CPF: $cpf");

        // Tenta autenticar como Paciente
        $paciente = Paciente::where('cpf', $cpf)->first();
        if ($paciente && Hash::check($request->password, $paciente->password)) {
            Auth::guard('paciente')->login($paciente);
            Log::info("Paciente autenticado com sucesso: " . $paciente->cpf);

            // Redireciona para a rota correta
            return redirect()->route('paciente.home')->with('success', 'Login realizado com sucesso!');
        }

        // Tenta autenticar como Doutor
        $doutor = Doutor::where('cpf', $cpf)->first();
        if ($doutor && Hash::check($request->password, $doutor->password)) {
            Auth::guard('doutor')->login($doutor);
            Log::info("Doutor autenticado com sucesso: " . $doutor->cpf);

            // Redireciona para a rota correta
            return redirect()->route('doutor.home')->with('success', 'Login realizado com sucesso!');
        }

        // Se chegar aqui, as credenciais são inválidas
        Log::error("Tentativa de login falhada para CPF: $cpf");
        return back()->withErrors(['login' => 'As credenciais fornecidas estão incorretas.'])->withInput();
    }

    public function handleGoogleCallback(Request $request)
    {
        $client = new Google_Client();
        $client->setClientId(config('google.client_id'));
        $client->setClientSecret(config('google.client_secret'));
        $client->setRedirectUri(config('google.redirect'));

        // Obter o código da URL (retornado pelo Google)
        $code = $request->get('code');
        $accessToken = $client->fetchAccessTokenWithAuthCode($code);

        if (isset($accessToken['error'])) {
            return redirect()->route('login')->with('error', 'Falha na autenticação do Google');
        }

        // Configura o token de acesso no cliente
        $client->setAccessToken($accessToken);

        try {
            $googleUser = $client->verifyIdToken($accessToken['id_token']);
            if (!$googleUser) {
                return redirect()->route('login')->with('error', 'Falha na autenticação do Google.');
            }

            // Aqui você pode usar os dados do Google, como e-mail do usuário, para autenticar o usuário no seu sistema
            $userEmail = $googleUser['email']; 
            $user = User::where('email', $userEmail)->first();

            if ($user) {
                Auth::login($user);
                return redirect()->route('home'); // Ou a rota de destino
            } else {
                // Criar o usuário automaticamente
                $user = User::create([
                    'name' => $googleUser['name'],
                    'email' => $googleUser['email'],
                    'password' => Hash::make(Str::random(16)), // Senha aleatória
                ]);

                Auth::login($user);
                return redirect()->route('home');
            }

        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Falha ao acessar a conta do Google.');
        }
    }

    public function redirectToGoogle()
    {
        $client = new Google_Client();
        $client->setClientId(config('google.client_id'));
        $client->setClientSecret(config('google.client_secret'));
        $client->setRedirectUri(config('google.redirect'));
        $client->addScope(Google_Service_Calendar::CALENDAR); // Ou qualquer outro escopo que você precise

        $authUrl = $client->createAuthUrl();

        return redirect($authUrl); // Redireciona o usuário para o Google
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Logout realizado com sucesso.');
    }
}
