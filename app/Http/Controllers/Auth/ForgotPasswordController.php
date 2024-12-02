<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /**
     * Exibe o formulário de solicitação de link de redefinição de senha.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        return view('auth.password-forgot'); // Certifique-se de que a view 'auth.password-forgot' exista
    }

    /**
     * Envia o link de redefinição de senha para o email fornecido.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        // Valida o email
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'Por favor, insira um endereço de email válido.',
        ]);

        // Tenta encontrar o usuário no modelo Doutor ou Paciente
        $user = \App\Models\Doutor::where('email', $request->email)->first() ?? \App\Models\Paciente::where('email', $request->email)->first();

        // Se o usuário não existir
        if (!$user) {
            return back()->withErrors(['email' => 'Este email não está registrado.']);
        }

        // Define o broker correto (doutores ou pacientes)
        $broker = $user instanceof \App\Models\Doutor ? 'doutores' : 'pacientes';

        // Envia o link de redefinição de senha
        $response = Password::broker($broker)->sendResetLink(
            $request->only('email')
        );

        // Verifica se o link foi enviado com sucesso
        return $response == Password::RESET_LINK_SENT
            ? back()->with('status', 'Enviamos um link para redefinição de senha para o seu e-mail!')
            : back()->withErrors(['email' => __($response)]);
    }

    /**
     * Exibe o formulário de redefinição de senha.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $token
     * @return \Illuminate\View\View
     */
    public function showResetForm(Request $request, $token)
    {
        return view('auth.password-reset', [
            'token' => $token,
        ]);
    }

    /**
     * Redefine a senha do usuário.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset(Request $request)
    {
        // Valida os dados fornecidos
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Verifica se o email corresponde a um doutor ou paciente
        $broker = \App\Models\Doutor::where('email', $request->email)->exists() ? 'doutores' : 'pacientes';

        // Tenta redefinir a senha
        $response = Password::broker($broker)->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password), // Atualiza a senha
                ])->save();
            }
        );

        // Retorna o status de redefinição
        return $response == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Senha redefinida com sucesso!')
            : back()->withErrors(['email' => __($response)]);
    }
}
