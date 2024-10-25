<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 
use App\Models\Doutor;
use App\Models\Paciente; 

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validação dos campos CPF e senha
        $request->validate([
            'cpf' => 'required|string',
            'password' => 'required|string',
        ]);

        \Log::info('Tentativa de login:', ['cpf' => $request->cpf]);

        // Autenticação do doutor
        $doutor = Doutor::where('cpf', $request->cpf)->first();
        if ($doutor && Hash::check($request->password, $doutor->senha)) {
            Auth::login($doutor);
            \Log::info('Login do doutor bem-sucedido: ', ['cpf' => $request->cpf]);
            return redirect('/doutor');
        }

        // Autenticação do paciente
        $paciente = Paciente::where('cpf', $request->cpf)->first();
        if ($paciente && Hash::check($request->password, $paciente->senha)) {
            Auth::login($paciente);
            \Log::info('Login do paciente bem-sucedido: ', ['cpf' => $request->cpf]);
            return redirect('/paciente');
        }

        // Se falhar, redireciona de volta com erro
        \Log::warning('Login falhou: ', ['cpf' => $request->cpf]);
        return back()->withErrors(['login' => 'As credenciais fornecidas estão incorretas.']);
    }
}
