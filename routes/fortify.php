<?php

use Laravel\Fortify\Fortify;
use App\Http\Controllers\Auth\RegisterController;

Fortify::ignoreRoutes(); // Para não usar as rotas padrão do Fortify

// Use o controlador de registro que você criou
Fortify::createUsersUsing(RegisterController::class);

Fortify::registerView(function () {
    return view('auth.register');
});

Fortify::loginView(function () {
    return view('auth.login');
});

// Outros métodos e configurações do Fortify
