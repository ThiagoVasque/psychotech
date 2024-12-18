<?php
use Laravel\Fortify\Fortify;
use App\Http\Controllers\Auth\RegisterController;

Fortify::ignoreRoutes(); // Ignora as rotas padrão do Fortify

Fortify::createUsersUsing(RegisterController::class);

Fortify::registerView(function () {
    return view('auth.register');
});

Fortify::loginView(function () {
    return view('auth.login'); 
});
