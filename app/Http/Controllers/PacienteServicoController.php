<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Doutor;
use App\Models\DoutorServico;
use Illuminate\Http\Request;
use App\Models\Slot;
use App\Models\Consulta;

class PacienteServicoController extends Controller
{
    // Método para exibir os serviços dos doutores
    public function index()
    {
        // Buscar todos os doutores com seus serviços
        $doutores = Doutor::with('servicos')->get();

        // Retornar a view com os doutores e serviços
        return view('paciente.servicos', compact('doutores'));
    }

    // Método para exibir os slots de um serviço
    public function exibirSlots(DoutorServico $servico)
    {
        // Obter os slots disponíveis para o serviço
        $slots = $servico->slots()->where('disponivel', true)->get();

        return view('paciente.servicos_slots', compact('servico', 'slots'));
    }

    // Método para agendar o serviço
    public function agendar(Request $request, DoutorServico $servico)
    {
        // Verificar se o serviço tem um doutor associado
        if (!$servico->doutor_cpf) {
            return redirect()->route('paciente.servicos')
                ->with('error', 'O serviço selecionado não possui doutor associado.');
        }

        $slot = Slot::where('doutor_servico_id', $servico->id)
            ->where('id', $request->slot_id)
            ->where('disponivel', true)
            ->first();

        if (!$slot) {
            return redirect()->route('paciente.servicos')
                ->with('error', 'Este slot não está disponível.');
        }

        // Criação do agendamento
        $agendamento = Consulta::create([
            'paciente_cpf' => Auth::guard('paciente')->user()->cpf,  // Obtendo o CPF do paciente autenticado
            'doutor_cpf' => $servico->doutor_cpf,  // Preenchendo o campo doutor_cpf com o doutor_cpf do serviço
            'anotacao' => null,  // Caso precise de anotação, adicione um campo no formulário
            'data_hora' => $slot->data_hora,  // Usando a data e hora do slot
            'link_doutor' => 'link-do-doutor',  // Aqui você pode gerar ou recuperar o link do doutor
            'link_paciente' => 'link-do-paciente',  // O mesmo para o paciente
            'status' => 'pendente',  // Definindo o status da consulta como 'pendente'
        ]);

        // Marca o slot como não disponível
        $slot->disponivel = false;
        $slot->save();

        return redirect()->route('paciente.consultas')
            ->with('success', 'Agendamento realizado com sucesso!');
    }


}
