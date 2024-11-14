<?php

namespace App\Http\Controllers;

use App\Models\DoutorServico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoutorServicoController extends Controller
{
    // Método para exibir todos os serviços do doutor
    public function index()
    {
        // Pega todos os serviços do doutor logado
        $servicos = DoutorServico::where('doutor_cpf', auth()->user()->cpf)->get();

        return view('doutor.servicos', compact('servicos'));
    }

    // Método para exibir o formulário de criação de serviços
    public function create()
    {
        $doutor = Auth::user();  // Pega o doutor logado
        return view('doutor.servicos', compact('doutor'));
    }

    // Método para armazenar um novo serviço
    public function store(Request $request)
    {
        // Validação de dados do serviço
        $dados = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'especialidade' => 'required|string',
            'preco' => 'required|numeric',
            'agenda_horarios' => 'array|required',
            'agenda_horarios.*.data_inicio_periodo' => 'required|date',
            'agenda_horarios.*.data_fim_periodo' => 'required|date',
            'agenda_horarios.*.hora_inicio' => 'required|date_format:H:i',
            'agenda_horarios.*.hora_fim' => 'required|date_format:H:i',
        ]);

        // Inserir os dados do serviço
        foreach ($dados['agenda_horarios'] as $horario) {
            DoutorServico::create([
                'doutor_cpf' => $request->doutor_cpf,
                'titulo' => $dados['titulo'],
                'descricao' => $dados['descricao'],
                'especialidade' => $dados['especialidade'],
                'preco' => $dados['preco'],
                'data_inicio_periodo' => $horario['data_inicio_periodo'],
                'data_fim_periodo' => $horario['data_fim_periodo'],
                'hora_inicio' => $horario['hora_inicio'],
                'hora_fim' => $horario['hora_fim'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('doutor.servicos')->with('success', 'Serviço cadastrado com sucesso!');
    }

    // Método para exibir o formulário de edição de um serviço
    public function edit($id)
    {
        $servico = DoutorServico::findOrFail($id);

        if ($servico->doutor_cpf != Auth::user()->cpf) {
            return redirect()->route('doutor.servicos')->with('error', 'Você não tem permissão para editar esse serviço.');
        }

        return view('doutor.edit_servico', compact('servico')); // Certifique-se de ter uma view separada para edição
    }

    // Método para atualizar um serviço existente
    public function update(Request $request, $id)
    {
        // Validação para campos principais
        $dados = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'especialidade' => 'required|string',
            'preco' => 'required|numeric',
        ]);

        $servico = DoutorServico::findOrFail($id);

        // Verifica se o doutor logado é o dono do serviço
        if ($servico->doutor_cpf != Auth::user()->cpf) {
            return redirect()->route('doutor.servicos')->with('error', 'Você não tem permissão para editar esse serviço.');
        }

        // Atualiza as informações principais do serviço
        $servico->update($dados);

        // Se a edição incluir a atualização dos horários
        if ($request->has('agenda_horarios')) {
            // Limpa os horários existentes antes de atualizar
            $servico->horarios()->delete();

            // Cria novos horários
            foreach ($request->agenda_horarios as $horario) {
                $servico->horarios()->create([
                    'data_inicio_periodo' => $horario['data_inicio_periodo'],
                    'data_fim_periodo' => $horario['data_fim_periodo'],
                    'hora_inicio' => $horario['hora_inicio'],
                    'hora_fim' => $horario['hora_fim'],
                ]);
            }
        }

        return redirect()->route('doutor.servicos')->with('success', 'Serviço atualizado com sucesso!');
    }

    // Método para excluir um serviço
    public function destroy($id)
    {
        $servico = DoutorServico::findOrFail($id);

        // Verifica se o doutor logado é o dono do serviço
        if ($servico->doutor_cpf != Auth::user()->cpf) {
            return redirect()->route('doutor.servicos')->with('error', 'Você não tem permissão para excluir esse serviço.');
        }

        $servico->delete();

        return redirect()->route('doutor.servicos')->with('success', 'Serviço excluído com sucesso!');
    }
}
