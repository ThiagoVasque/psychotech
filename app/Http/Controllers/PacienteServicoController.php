<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Doutor;
use App\Models\DoutorServico;

class PacienteServicoController extends Controller
{
    // Método para exibir os doutores e seus serviços
    public function index()
    {
        $doutores = Doutor::with('servicos')->get(); // Carrega doutores com serviços
        return view('paciente.servicos', compact('doutores'));
    }

    // Método para agendar um serviço
    public function agendar(Request $request, $servicoId)
    {
        $paciente = Auth::user();

        return redirect()->route('paciente.servicos')->with('success', 'Consulta agendada com sucesso!');
    }
}
