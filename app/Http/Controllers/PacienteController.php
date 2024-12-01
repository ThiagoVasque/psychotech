<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Doutor;
use App\Models\DoutorServico;
use App\Models\Consulta;

class PacienteController extends Controller
{
    // Método para exibir a página inicial do paciente
    public function home()
    {
        return view('paciente.home');
    }

    public function gerencia()
    {
        return view('paciente.gerencia_perfil');
    }

    // Método para exibir sessões agendadas
    public function consultas()
    {
        $paciente = Auth::user();

        $consultas = Consulta::where('paciente_cpf', $paciente->cpf)->get();

        return view('paciente.consultas', compact('paciente', 'consultas'));
    }

    //Método para exibir os serviços dos doutores
    public function doutores()
    {
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
