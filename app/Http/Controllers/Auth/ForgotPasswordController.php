<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /**
     * Exibe o formulário de solicitação de redefinição de senha.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        return view('auth.password-reset'); // Certifique-se de que a view 'auth.password-reset' exista
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
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'Por favor, insira um endereço de email válido.',
            'email.exists' => 'Este endereço de email não foi encontrado em nossos registros.',
        ]);

        // Tenta enviar o link de redefinição
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Retorna uma resposta baseada no status
        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }
}
