<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsDoutor
{
    public function handle($request, Closure $next)
    {
        // Verifica se o usuário autenticado é uma instância de Doutor
        if (Auth::check() && Auth::user() instanceof \App\Models\Doutor) {
            return $next($request);
        }

        // Redireciona para a rota de home se não for doutor
        return redirect()->route('home'); 
    }
}
