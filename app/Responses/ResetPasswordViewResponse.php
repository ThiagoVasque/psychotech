<?php

namespace App\Responses;

use Laravel\Fortify\Contracts\ResetPasswordViewResponse;
namespace App\Responses;

class ResetPasswordViewResponse implements ResetPasswordViewResponse
{
    public function toResponse($request)
    {
        return view('auth.password-reset'); 
    }
}
