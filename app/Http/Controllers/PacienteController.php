<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PacienteController extends Controller
{
    // Método para exibir a página inicial do paciente
    public function home()
    {
        return view('paciente.home');
    }

    // Método para exibir sessões agendadas
    public function sessoes()
    {
        $paciente = Auth::user();
        return view('paciente.sessoes', compact('paciente'));
    }

    // Método para exibir e criar anotações
    public function anotacoes()
    {
        $paciente = Auth::user(); 
        return view('paciente.anotacoes', compact('paciente'));
    }

    // Método para exibir histórico de sessões
    public function historico()
    {
        $paciente = Auth::user(); 
        return view('paciente.historico', compact('paciente'));
    }
}
