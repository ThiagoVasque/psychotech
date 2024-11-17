<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Slot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ZoomService;

class ConsultaController extends Controller
{
    // Método para listar consultas do paciente autenticado
    public function index()
    {
        // Obtendo o paciente autenticado
        $paciente = Auth::guard('paciente')->user();

        if (!$paciente) {
            return redirect()->route('login')->withErrors('Você precisa estar autenticado como paciente.');
        }

        // Recuperando todas as consultas do paciente
        $consultas = Consulta::where('paciente_cpf', $paciente->cpf)->get();

        // Retornar a view com as consultas
        return view('paciente.consultas', compact('consultas'));
    }

    // Método para agendar uma consulta
    public function agendar(Request $request, $slotId)
    {
        // Validar os dados recebidos
        $request->validate([
            'doutor_cpf' => 'required|string',
            'paciente_cpf' => 'required|string',
            'anotacao' => 'nullable|string|max:255',
        ]);

        // Buscar o slot pelo ID
        $slot = Slot::findOrFail($slotId);

        // Garantir que o slot está disponível
        if (!$slot->disponivel) {
            return redirect()->back()->withErrors('O slot selecionado não está disponível.');
        }

        // Criar uma nova consulta
        $consulta = new Consulta();
        $consulta->doutor_cpf = $request->doutor_cpf;
        $consulta->paciente_cpf = $request->paciente_cpf;
        $consulta->data_hora = $slot->data_hora;
        $consulta->anotacao = $request->anotacao;

        // Gerar o link da videochamada usando o serviço Zoom
        $zoomService = new ZoomService();
        $zoomMeeting = $zoomService->createMeeting($consulta->data_hora);

        if (!$zoomMeeting) {
            return redirect()->back()->withErrors('Erro ao criar a videochamada. Tente novamente.');
        }

        // Armazenar os links gerados
        $consulta->link_doutor = $zoomMeeting['doutor_link'];
        $consulta->link_paciente = $zoomMeeting['paciente_link'];
        $consulta->save();

        // Marcar o slot como indisponível
        $slot->disponivel = false;
        $slot->paciente_cpf = $request->paciente_cpf;
        $slot->save();

        return redirect()->route('paciente.consultas')->with('success', 'Consulta agendada com sucesso.');
    }

    // Método para cancelar uma consulta
    public function cancelar($id)
    {
        // Encontrar a consulta pelo ID
        $consulta = Consulta::find($id);

        if (!$consulta) {
            return response()->json([
                'status' => 'error',
                'message' => 'Consulta não encontrada.'
            ]);
        }

        // Buscar o slot relacionado pela data e doutor
        $slot = Slot::where('data_hora', $consulta->data_hora)
            ->where('doutor_cpf', $consulta->doutor_cpf)
            ->first();

        if ($slot) {
            // Marcar o slot como disponível novamente
            $slot->disponivel = true;
            $slot->paciente_cpf = null; // Limpando o vínculo com o paciente
            $slot->save();
        }

        // Excluir a consulta
        $consulta->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Consulta cancelada e slot liberado.'
        ]);
    }
}
