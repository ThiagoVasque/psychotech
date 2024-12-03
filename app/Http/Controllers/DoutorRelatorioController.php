<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class DoutorRelatorioController extends Controller
{
    public function index(Request $request)
    {
        // Obtém o doutor logado
        $doutor = Auth::user();

        // Inicia a consulta filtrando pelo doutor
        $query = Consulta::where('doutor_cpf', $doutor->cpf);

        // Filtro por nome do paciente
        if ($request->has('nome') && $request->nome) {
            $query->whereHas('paciente', function ($q) use ($request) {
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

        // Calcular o total
        $total = $consultas->sum('valor');

        // Retornar a view com os dados
        return view('doutor.relatorios', compact('consultas', 'total'));
    }


}
