<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Doutor;
use App\Models\Paciente;
use Illuminate\Support\Facades\Log;

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

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Logout realizado com sucesso.');
    }
}
