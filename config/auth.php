<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    */

    'defaults' => [
        'guard' => 'paciente', // Mude para 'paciente' ou 'doutor' conforme necessário
        'passwords' => 'pacientes', // Use o broker correto
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    */

    'guards' => [
        'paciente' => [
            'driver' => 'session',
            'provider' => 'pacientes',
        ],
        'doutor' => [
            'driver' => 'session',
            'provider' => 'doutores',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    */

    'providers' => [
        'pacientes' => [
            'driver' => 'eloquent',
            'model' => App\Models\Paciente::class,
        ],
        'doutores' => [
            'driver' => 'eloquent',
            'model' => App\Models\Doutor::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    */

    'passwords' => [
        'pacientes' => [
            'provider' => 'pacientes',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
        'doutores' => [
            'provider' => 'doutores',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    */

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),
];
