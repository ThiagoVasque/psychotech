<?php

namespace App\Http\Controllers;

use App\Models\Slot;
use App\Models\Agendamento;
use App\Models\DoutorServico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PacienteServicoController extends Controller
{
    public function agendar(Request $request, DoutorServico $servico)
    {
        // Verifica se o slot está disponível
        $slot = Slot::where('doutor_servico_id', $servico->id)
            ->where('id', $request->slot_id)
            ->where('disponivel', true)
            ->first();

        if (!$slot) {
            return redirect()->route('paciente.servicos')
                ->with('error', 'Este slot não está disponível.');
        }

        // Cria o agendamento
        $agendamento = Agendamento::create([
            'paciente_cpf' => Auth::guard('paciente')->user()->cpf,
            'doutor_servico_id' => $servico->id,
            'slot_id' => $slot->id,
            'status' => 'pendente', 
        ]);

        // Marca o slot como não disponível
        $slot->disponivel = false;
        $slot->save();

        // Redireciona com sucesso
        return redirect()->route('paciente.consultas')
            ->with('success', 'Agendamento realizado com sucesso!');
    }


}
