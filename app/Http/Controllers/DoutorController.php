<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Consulta;

class DoutorController extends Controller
{
    public function __construct()
    {
        // Garantir que apenas doutores possam acessar essas rotas
        $this->middleware('auth:doutor');  // Protege as rotas para doutores
    }

    public function home()
    {
        // O usuário será automaticamente um doutor após o login
        $doutor = Auth::user();
        return view('doutor.home', compact('doutor'));
    }

    public function consultas()
    {
        $doutor = Auth::user();

        if (!$doutor) {
            return redirect()->route('login')->withErrors('Você precisa estar autenticado como doutor.');
        }

        // Recupere as consultas do doutor
        $consultas = Consulta::where('doutor_cpf', $doutor->cpf)->get();

        // Retorne a view com a variável $consultas
        return view('doutor.consultas', compact('consultas'));
    }



    public function servicos()
    {
        $doutor = Auth::user();
        return view('doutor.servicos', compact('doutor'));
    }

    public function relatorios()
    {
        $doutor = Auth::user();
        return view('doutor.relatorios', compact('doutor'));
    }
}
