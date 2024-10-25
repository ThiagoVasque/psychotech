<?php

use Laravel\Fortify\Fortify;
use Laravel\Fortify\Features;
use App\Http\Controllers\RegisterController;

Fortify::createUsersUsing(RegisterController::class);

return [
    'guard' => 'web',

    'passwords' => 'users',

    'username' => 'email', // Define 'email' como o campo de login

    'email' => 'email',

    'lowercase_usernames' => true, // Armazena nomes de usuário em minúsculas

    'home' => '/home', // Caminho para redirecionar após login

    'prefix' => '', // Prefixo para as rotas do Fortify

    'domain' => null, // Domínio para as rotas do Fortify

    'middleware' => ['web'], // Middleware padrão para as rotas

    'limiters' => [
        'login' => 'login',
        'two-factor' => 'two-factor',
    ],

    'views' => true, // Habilita views para registro e login

    'features' => [
        Features::registration(), // Habilita registro de usuários
        Features::resetPasswords(), // Habilita redefinição de senhas
        // Features::emailVerification(), // Descomente se precisar de verificação de e-mail
        Features::updateProfileInformation(), // Habilita atualização de informações do perfil
        Features::updatePasswords(), // Habilita atualização de senhas
        Features::twoFactorAuthentication([ // Habilita autenticação de dois fatores
            'confirm' => true,
            'confirmPassword' => true,
            // 'window' => 0, // Descomente e ajuste se precisar de uma janela de verificação
        ]),
    ],
];
