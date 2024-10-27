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
        // Aqui você pode obter as sessões agendadas do paciente autenticado
        $paciente = Auth::user(); // Obtém o paciente autenticado
        // Lógica para recuperar as sessões do paciente, se necessário
        return view('paciente.sessoes', compact('paciente'));
    }

    // Método para exibir e criar anotações
    public function anotacoes()
    {
        // Lógica para exibir e criar anotações
        $paciente = Auth::user(); // Obtém o paciente autenticado
        // Você pode passar os dados de anotações para a view se necessário
        return view('paciente.anotacoes', compact('paciente'));
    }

    // Método para exibir pagamentos
    public function pagamentos()
    {
        // Lógica para exibir pagamentos
        $paciente = Auth::user(); // Obtém o paciente autenticado
        // Você pode passar os dados de pagamentos para a view se necessário
        return view('paciente.pagamentos', compact('paciente'));
    }

    // Método para exibir histórico de sessões
    public function historico()
    {
        // Lógica para exibir histórico de sessões
        $paciente = Auth::user(); // Obtém o paciente autenticado
        // Você pode passar os dados do histórico para a view se necessário
        return view('paciente.historico', compact('paciente'));
    }
}
