<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Slot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgendamentoController extends Controller
{
    public function agendar(Request $request)
    {
        // Obtém o paciente autenticado
        $paciente = Auth::guard('paciente')->user();

        // Valida o ID do slot selecionado
        $slot = Slot::find($request->slot_id);

        // Verifica se o slot existe e está disponível
        if ($slot && $slot->disponivel) {
            // Cria o agendamento
            $agendamento = Agendamento::create([
                'paciente_cpf' => $paciente->cpf,
                'slot_id' => $slot->id,
                'status' => 'pendente',  // ou 'confirmado', dependendo da lógica
            ]);

            // Marca o slot como indisponível
            $slot->disponivel = false;
            $slot->save();

            return redirect()->route('paciente.home')->with('success', 'Agendamento realizado com sucesso!');
        }

        return back()->with('error', 'Slot indisponível ou inválido.');
    }
}
