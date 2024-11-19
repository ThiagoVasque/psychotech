<?php

use Laravel\Fortify\Fortify;
use Laravel\Fortify\Features;
use App\Http\Controllers\Auth\RegisterController;

return [
    'guard' => 'web',

    'passwords' => 'users',

    'username' => 'cpf',

    'email' => 'email',

    'lowercase_usernames' => true,

    'home' => '/home',

    'prefix' => '',

    'domain' => null,

    'middleware' => ['web'],

    'limiters' => [
        'login' => 'login',
        'two-factor' => 'two-factor',
    ],

    'views' => true,

    'features' => [
        Features::registration(), 
        Features::resetPasswords(), 
        Features::updateProfileInformation(), 
        Features::updatePasswords(), 
        Features::twoFactorAuthentication([ 
            'confirm' => true,
            'confirmPassword' => true,
        ]),
    ],

    'passwords' => [
        'pacientes' => [
            'provider' => 'pacientes',
            'table' => 'pacientes',
            'expire' => 60,
            'throttle' => 180, 
        ],
        'doutores' => [
            'provider' => 'doutores',
            'table' => 'doutores',
            'expire' => 60,
            'throttle' => 180, 
        ],
    ],
];
