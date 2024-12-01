<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Password;
use App\Models\Paciente;
use App\Models\Doutor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ForgotPasswordController extends Controller
{
    /**
     * Exibe o formulário de solicitação de link de redefinição de senha.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        return view('auth.password-forgot');
    }

    /**
     * Envia o link de redefinição de senha para o email.
     */
    public function sendResetLinkEmail(Request $request)
    {
        // Validação de email
        $request->validate(['email' => 'required|email']); // Valide o email

        // Tentar encontrar o usuário no modelo Paciente ou Doutor
        $user = Paciente::where('email', $request->email)->first()
            ?? Doutor::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'Não encontramos um usuário com este email.']);
        }

        // Definir o broker correto (pacientes ou doutores)
        $broker = $user instanceof Paciente ? 'pacientes' : 'doutores';

        // Enviar o link de redefinição de senha
        $response = Password::broker($broker)->sendResetLink(
            ['email' => $user->email] // Enviar o email para o link de redefinição
        );

        // Redirecionar de volta com sucesso ou erro
        if ($response == Password::RESET_LINK_SENT) {
            return redirect()->route('password.request')->with('status', 'Enviamos um link para redefinição de senha!');
        }

        return redirect()->back()->withErrors(['email' => trans($response)]);
    }

    /**
     * Exibe o formulário de redefinição de senha.
     */
    public function showResetForm(Request $request, $token)
    {
        return view('auth.password-reset', ['token' => $token]);
    }


    /**
     * Redefine a senha sem precisar solicitar o email ou CPF novamente.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Determina o broker baseado no email
        $broker = $request->has('email') && \App\Models\Doutor::where('email', $request->email)->exists()
            ? 'doutores'
            : 'pacientes';

        // Realiza o reset de senha
        $response = Password::broker($broker)->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password),
                ])->save();
            }
        );

        return $response == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($response))
            : back()->withErrors(['email' => __($response)]);
    }

}
