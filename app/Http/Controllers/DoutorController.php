<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoutorController extends Controller
{
    public function home()
    {
        $doutor = Auth::user(); 
        return view('doutor.home', compact('doutor'));
    }

    public function pacientes()
    {
        $doutor = Auth::user(); 
        return view('doutor.pacientes', compact('doutor'));
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

    public function videoconferencia()
    {
        $doutor = Auth::user(); 
        return view('doutor.videoconferencia', compact('doutor'));
    }
}
