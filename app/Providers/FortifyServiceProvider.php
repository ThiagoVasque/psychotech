<?php

namespace App\Providers;

use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use App\Models\Doutor;
use App\Models\Paciente;
use App\Http\Controllers\Auth\RegisterController; // Adicione essa linha

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Adicione aqui os registros necessários, se houver
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Use o controlador de registro que você criou
        Fortify::createUsersUsing(RegisterController::class);

        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // Autenticação usando CPF e password
        Fortify::authenticateUsing(function (Request $request) {
            $user = Doutor::where('cpf', $request->cpf)->first() ?? Paciente::where('cpf', $request->cpf)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                return $user;
            }
            return null;
        });

        Fortify::loginView(function () {
            return view('auth.login');
        });

        Fortify::registerView(function () {
            return view('auth.register');
        });

        // Limitação de taxa para login
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::lower($request->input(Fortify::username())) . '|' . $request->ip();
            return Limit::perMinute(5)->by($throttleKey);
        });

        // Limitação de taxa para autenticação de dois fatores
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
