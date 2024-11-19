<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Password;
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
        $request->validate([
            'email' => 'required|email', 
        ]);

        // Descobre qual broker usar com base no tipo de usuário (doutor ou paciente)
        $user = \App\Models\Doutor::where('email', $request->email)->first() ?? \App\Models\Paciente::where('email', $request->email)->first();

        if ($user) {
            $broker = $user instanceof \App\Models\Doutor ? 'doutores' : 'pacientes';

            // Envia o link de redefinição de senha
            $response = Password::broker($broker)->sendResetLink($request->only('email'));

            return $response == Password::RESET_LINK_SENT
                ? back()->with('status', __($response))
                : back()->withErrors(['email' => __($response)]);
        }

        // Caso o email não exista
        return back()->withErrors(['email' => 'Este email não está registrado.']);
    }

    /**
     * Exibe o formulário de redefinição de senha.
     */
    public function showResetForm(Request $request, $token)
    {
        return view('auth.password-reset', [
            'token' => $token,
        ]);
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

        $broker = $request->has('email') && \App\Models\Doutor::where('email', $request->email)->exists()
            ? 'doutores'
            : 'pacientes';

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
