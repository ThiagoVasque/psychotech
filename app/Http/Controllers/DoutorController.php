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
        // Aqui você pode obter a lista de pacientes associados ao doutor autenticado
        $doutor = Auth::user(); // Obtém o doutor autenticado
        // Lógica para recuperar a lista de pacientes, se necessário
        return view('doutor.pacientes', compact('doutor'));
    }

    // Método para gerenciar sessões
    public function sessoes()
    {
        // Lógica para gerenciar sessões
        $doutor = Auth::user(); // Obtém o doutor autenticado
        // Você pode passar dados de sessões para a view se necessário
        return view('doutor.sessoes', compact('doutor'));
    }

    // Método para gerar relatórios
    public function relatorios()
    {
        // Lógica para gerar relatórios
        $doutor = Auth::user(); // Obtém o doutor autenticado
        // Você pode passar dados para a view se necessário
        return view('doutor.relatorios', compact('doutor'));
    }

    // Método para criar e gerenciar videoconferências
    public function videoconferencia()
    {
        // Lógica para criar e gerenciar videoconferências
        $doutor = Auth::user(); // Obtém o doutor autenticado
        // Você pode passar dados de videoconferência para a view se necessário
        return view('doutor.videoconferencia', compact('doutor'));
    }
}
