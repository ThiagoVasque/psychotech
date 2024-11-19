<?php

return [

    /*
    |----------------------------------------------------------------------
    | Authentication Defaults
    |----------------------------------------------------------------------
    |
    | These are the default settings for authentication. You may change them
    | as needed to customize your application's authentication services.
    |
    */

    'defaults' => [
        'guard' => 'paciente', 
        'passwords' => 'pacientes', 
    ],

    /*
    |----------------------------------------------------------------------
    | Authentication Guards
    |----------------------------------------------------------------------
    |
    | Guards define how users are authenticated for each request. You may
    | define multiple guards for your application, but one must be set as
    | the default.
    |
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
    |----------------------------------------------------------------------
    | User Providers
    |----------------------------------------------------------------------
    |
    | Providers define how the users are retrieved from your database or
    | other storage mechanisms used by your application. You can configure
    | multiple providers if you need to.
    |
    */

    'providers' => [
        'doutores' => [
            'driver' => 'eloquent',
            'model' => App\Models\Doutor::class,
            'key' => 'email', // Certifique-se de usar email
        ],

        'pacientes' => [
            'driver' => 'eloquent',
            'model' => App\Models\Paciente::class,
            'key' => 'email', // Certifique-se de usar email
        ],
    ],

    /*
    |----------------------------------------------------------------------
    | Resetting Passwords
    |----------------------------------------------------------------------
    |
    | Define how the password reset process will work. You may configure
    | different password reset options for each user type. Make sure
    | you are using the correct password broker and table for each.
    |
    */

    'passwords' => [
        'pacientes' => [
            'provider' => 'pacientes',
            'table' => 'password_reset_tokens',
            'expire' => 60,
        ],
        'doutores' => [
            'provider' => 'doutores',
            'table' => 'password_reset_tokens',
            'expire' => 60,
        ],
    ],

    /*
    |----------------------------------------------------------------------
    | Password Confirmation Timeout
    |----------------------------------------------------------------------
    |
    | This is the number of seconds before the password confirmation times out.
    | If the timeout is reached, the user will need to re-enter their password.
    |
    */

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),
];
