<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        // Adiciona uma verificação para evitar redirecionamento
        if (Auth::guard($guard)->check()) {
            // Verifica se a rota atual é de login ou registro
            if ($request->is('login') || $request->is('register')) {
                return $next($request); // Permite acesso à página de login ou registro
            }
    
            if (session('user_role') === 'doutor') {
                return redirect()->route('doutor.home');
            } elseif (session('user_role') === 'paciente') {
                return redirect()->route('paciente.home');
            }
        }
    
        return $next($request);
    }
    
}
