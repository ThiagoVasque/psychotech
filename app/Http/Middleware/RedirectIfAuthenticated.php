<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        // Verifica se o usuário já está autenticado
        if (Auth::check()) {
            // Verifica se é um Doutor
            if (Auth::user() instanceof \App\Models\Doutor) {
                return redirect()->route('doutor.home');
            }

            // Verifica se é um Paciente
            if (Auth::user() instanceof \App\Models\Paciente) {
                return redirect()->route('paciente.home');
            }
        }

        return $next($request);
    }
}
