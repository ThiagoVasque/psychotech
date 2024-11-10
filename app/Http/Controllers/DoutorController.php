<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoutorController extends Controller
{
    // Método para exibir a página inicial do doutor
    public function home()
    {
        return view('doutor.home');
    }

    // Método para exibir a lista de pacientes
    public function index()
    {
        $doutor = Auth::user(); 
        return view('doutor.pacientes', compact('doutor'));
    }

    // Método para gerenciar sessões
    public function sessoes()
    {
        $doutor = Auth::user();
        return view('doutor.sessoes', compact('doutor'));
    }

    // Método para gerar relatórios
    public function relatorios()
    {
        $doutor = Auth::user(); 
        return view('doutor.relatorios', compact('doutor'));
    }

    public function videoconferencia()
    {
        $doutor = Auth::user(); 
        return view('doutor.videoconferencia', compact('doutor'));
    }
}
