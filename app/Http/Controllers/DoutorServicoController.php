<?php

namespace App\Http\Controllers;

use App\Models\DoutorServico;
use Illuminate\Http\Request;

class DoutorServicoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:doutor');
    }

    // Lista os serviços do doutor autenticado
    public function index()
    {
        // Certifique-se de que a variável 'servicos' está sendo passada corretamente
        $servicos = DoutorServico::where('doutor_cpf', auth()->user()->cpf)->get();
        return view('doutor.sessoes', compact('servicos'));
    }

    // Exibe o formulário para criar um novo serviço
    public function create()
    {
        return view('doutor.criar_servico');
    }

    // Cria um novo serviço
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'especialidade' => 'required|string',
            'preco' => 'required|numeric',
        ]);

        DoutorServico::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'especialidade' => $request->especialidade,
            'preco' => $request->preco,
            'doutor_cpf' => auth()->user()->cpf,
        ]);

        return redirect()->route('doutor.sessoes')->with('success', 'Serviço criado com sucesso!');
    }

    // Exibe o formulário para editar um serviço
    public function edit(DoutorServico $servico)
    {
        if ($servico->doutor_cpf !== auth()->user()->cpf) {
            return redirect()->route('doutor.sessoes')->with('error', 'Você não tem permissão para editar este serviço.');
        }

        return view('doutor.editar_servico', compact('servico'));
    }

    // Atualiza um serviço
    public function update(Request $request, DoutorServico $servico)
    {
        if ($servico->doutor_cpf !== auth()->user()->cpf) {
            return redirect()->route('doutor.sessoes')->with('error', 'Você não tem permissão para atualizar este serviço.');
        }

        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'especialidade' => 'required|string',
            'preco' => 'required|numeric',
        ]);

        $servico->update($request->only('titulo', 'descricao', 'especialidade', 'preco'));

        return redirect()->route('doutor.sessoes')->with('success', 'Serviço atualizado com sucesso!');
    }

    // Exclui um serviço
    public function destroy(DoutorServico $servico)
    {
        if ($servico->doutor_cpf !== auth()->user()->cpf) {
            return redirect()->route('doutor.sessoes')->with('error', 'Você não tem permissão para remover este serviço.');
        }

        $servico->delete();

        return redirect()->route('doutor.sessoes')->with('success', 'Serviço excluído com sucesso!');
    }
}
