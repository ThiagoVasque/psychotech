<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Aqui você pode definir middlewares para as rotas
        $router = $this->app['router'];

        // Middleware para redirecionar usuários não autenticados
        $router->middleware('auth')->group(function () {
            // Rotas para Doutores
            Route::middleware('isDoutor')->group(function () {
                Route::get('/doutor', 'DoutorController@index')->name('doutor.home');
                // Adicione mais rotas para doutores aqui
            });

            // Rotas para Pacientes
            Route::middleware('isPaciente')->group(function () {
                Route::get('/paciente', 'PacienteController@index')->name('paciente.home');
                // Adicione mais rotas para pacientes aqui
            });
        });
    }
}
