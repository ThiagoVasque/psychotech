<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diario;
use Illuminate\Support\Facades\Auth;

class DiarioController extends Controller
{
    // Exibir a lista de anotações
    public function index()
    {
        // Pega todas as anotações do paciente autenticado
        $anotacoes = Diario::where('paciente_cpf', Auth::user()->cpf)->get();
        return view('paciente.diario', compact('anotacoes'));
    }

    // Armazenar uma nova anotação
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'texto' => 'required|string',
        ]);

        // Cria uma nova anotação
        Diario::create([
            'paciente_cpf' => Auth::user()->cpf,
            'titulo' => $request->titulo,
            'texto' => $request->texto,
        ]);

        return redirect()->route('paciente.diario')->with('success', 'Anotação adicionada com sucesso!');
    }

    // Atualizar uma anotação existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'texto' => 'required|string',
        ]);

        // Encontra a anotação pelo ID
        $anotacao = Diario::where('id', $id)
            ->where('paciente_cpf', Auth::user()->cpf)
            ->firstOrFail();

        // Atualiza a anotação
        $anotacao->update($request->only(['titulo', 'texto']));

        return redirect()->route('paciente.diario')->with('success', 'Anotação atualizada com sucesso!');
    }

    // Excluir uma anotação
    public function destroy($id)
    {
        // Encontra a anotação pelo ID e pelo CPF do paciente autenticado
        $anotacao = Diario::where('id', $id)
            ->where('paciente_cpf', Auth::user()->cpf)
            ->firstOrFail();

        // Exclui a anotação
        $anotacao->delete();

        return redirect()->route('paciente.diario')->with('success', 'Anotação excluída com sucesso!');
    }
}
