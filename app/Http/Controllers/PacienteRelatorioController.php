<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use Illuminate\Http\Request;

class PacienteRelatorioController extends Controller
{
    public function index(Request $request)
    {
        // Obtém o paciente logado
        $paciente = auth()->user();

        // Inicia a consulta filtrando pelo paciente
        $query = Consulta::where('paciente_cpf', $paciente->cpf);

        // Filtro por nome do doutor
        if ($request->has('nome') && $request->nome) {
            $query->whereHas('doutor', function ($q) use ($request) {
                $q->where('nome', 'like', '%' . $request->nome . '%');
            });
        }

        // Filtro por data de início e fim
        if ($request->has('data_inicio') && $request->data_inicio) {
            $query->where('data_hora', '>=', $request->data_inicio);
        }

        if ($request->has('data_fim') && $request->data_fim) {
            $query->where('data_hora', '<=', $request->data_fim);
        }

        // Obter as consultas filtradas
        $consultas = $query->get();

        // Retornar a view com os dados
        return view('paciente.historico', compact('consultas'));
    }

}
