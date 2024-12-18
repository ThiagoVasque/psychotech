<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Proner\Cpf; 
use Laravel\Fortify\Contracts\ResetPasswordViewResponse as ResetPasswordViewResponseContract;
use App\Responses\ResetPasswordViewResponse;

class AppServiceProvider extends ServiceProvider
{
    /**
     *
     * @return void
     */
    public function boot()
    {
        // Registra a validação personalizada para CPF
        Validator::extend('cpf', function ($attribute, $value, $parameters, $validator) {
            return Cpf::validate($value); 
        });
    }

    /**
     * Registre os serviços de aplicação.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ResetPasswordViewResponseContract::class, ResetPasswordViewResponse::class);
    }
}
