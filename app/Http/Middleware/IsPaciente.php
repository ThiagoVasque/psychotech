<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsPaciente
{
    public function handle($request, Closure $next)
    {
        // Verifica se o usuário autenticado é uma instância de Paciente
        if (Auth::check() && Auth::user() instanceof \App\Models\Paciente) {
            return $next($request);
        }

        // Redireciona para a rota de home se não for paciente
        return redirect()->route('home'); 
    }
}
