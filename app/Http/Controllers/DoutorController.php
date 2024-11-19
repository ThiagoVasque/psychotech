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
    // Recupera o doutor logado
    $doutor = Auth::user(); 

    // Recupera as consultas do doutor logado (ajuste conforme a relação entre Doutor e Consulta)
    $consultas = Consulta::where('doutor_cpf', $doutor->cpf)->get();

    // Passa as consultas para a view
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
