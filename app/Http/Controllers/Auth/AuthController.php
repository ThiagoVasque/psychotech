<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Doutor;
use App\Models\Paciente;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'cpf' => 'required|string',
            'password' => 'required|string',
        ]);

        $cpf = preg_replace('/[^\d]/', '', $request->cpf);

        $doutor = Doutor::where('cpf', $cpf)->first();
        if ($doutor) {
            if (Hash::check($request->password, $doutor->senha)) {
                Auth::guard('doutor')->login($doutor);
                session(['user_role' => 'doutor']);
                return redirect()->route('doutor.home')->with('success', 'Login realizado com sucesso!');
            }
        }

        $paciente = Paciente::where('cpf', $cpf)->first();
        if ($paciente) {
            if (Hash::check($request->password, $paciente->senha)) {
                Auth::guard('paciente')->login($paciente);
                session(['user_role' => 'paciente']);
                return redirect()->route('paciente.home')->with('success', 'Login realizado com sucesso!');
            }
        }

        return back()->withErrors(['login' => 'As credenciais fornecidas estão incorretas.'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Logout realizado com sucesso.');
    }
}
