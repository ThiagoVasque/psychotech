<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if (Auth::guard('doutor')->check()) {
                return redirect()->route('doutor.home');
            } elseif (Auth::guard('paciente')->check()) {
                return redirect()->route('paciente.home');
            }
            return redirect('/home');
        }
        return $next($request);
    }

}
