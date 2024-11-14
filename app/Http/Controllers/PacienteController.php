<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Doutor;
use App\Models\DoutorServico;

class PacienteController extends Controller
{
    // Método para exibir a página inicial do paciente
    public function home()
    {
        return view('paciente.home');
    }

    // Método para exibir sessões agendadas
    public function consultas()
    {
        $paciente = Auth::user();
        return view('paciente.consultas', compact('paciente'));
    }

    //Método para exibir os serviços dos doutores
    public function doutores()
    {
        // Buscar todos os doutores com seus serviços
        $doutores = Doutor::with('servicos')->get();

        return view('paciente.servicos', compact('doutores'));
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
