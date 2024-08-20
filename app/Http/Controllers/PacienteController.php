<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PacienteController extends Controller
{
    public function sessoes()
    {
        // Lógica para exibir sessões agendadas
        return view('paciente.sessoes');
    }

    public function anotacoes()
    {
        // Lógica para exibir e criar anotações
        return view('paciente.anotacoes');
    }

    public function pagamentos()
    {
        // Lógica para exibir pagamentos
        return view('paciente.pagamentos');
    }

    public function historico()
    {
        // Lógica para exibir histórico de sessões
        return view('paciente.historico');
    }
}
