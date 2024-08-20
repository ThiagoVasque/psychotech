<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DoutorController extends Controller
{
    public function index()
    {
        // Lógica para exibir a lista de pacientes
        return view('doutor.pacientes');
    }

    public function sessoes()
    {
        // Lógica para gerenciar sessões
        return view('doutor.sessoes');
    }

    public function relatorios()
    {
        // Lógica para gerar relatórios
        return view('doutor.relatorios');
    }

    public function videoconferencia()
    {
        // Lógica para criar e gerenciar videoconferências
        return view('doutor.videoconferencia');
    }
}
