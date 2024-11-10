<?php
use Laravel\Fortify\Fortify;
use App\Http\Controllers\Auth\RegisterController;

Fortify::ignoreRoutes(); // Ignora as rotas padrão do Fortify

// Usando o controlador de registro personalizado
Fortify::createUsersUsing(RegisterController::class);

// Configurando as views
Fortify::registerView(function () {
    return view('auth.register');
});

Fortify::loginView(function () {
    return view('auth.login'); 
});
