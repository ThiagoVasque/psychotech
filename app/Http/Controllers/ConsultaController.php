<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Slot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ZoomService;

class ConsultaController extends Controller
{
    protected $zoomService;

    // importando Zoom
    public function __construct(ZoomService $zoomService)
    {
        $this->zoomService = $zoomService;
    }

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

    // Método para agendar a consulta
    public function agendar(Request $request, $slotId)
    {
        // Verificar se o paciente está autenticado
        $paciente = Auth::guard('paciente')->user();
        if (!$paciente) {
            return redirect()->route('login')->withErrors('Você precisa estar autenticado como paciente.');
        }

        // Validações básicas
        $request->validate([
            'doutor_cpf' => 'required|exists:doutores,cpf',
            'paciente_cpf' => 'required|exists:pacientes,cpf',
            'data_hora' => 'required|date',
        ]);

        // Verificar se o slot está disponível
        $slot = Slot::findOrFail($slotId);
        if (!$slot->disponivel) {
            return redirect()->back()->with('error', 'Slot não disponível.');
        }

        // Criar a reunião no Zoom
        $zoomData = [
            'topic' => 'Consulta Médica',
            'type' => 2, 
            'start_time' => $request->input('data_hora'),
            'duration' => 30,
            'settings' => [
                'join_before_host' => true,
                'waiting_room' => false,
            ],
        ];

        try {
           
            $zoomMeeting = $this->zoomService->createMeeting($zoomData);

           
            $linkDoutor = $zoomMeeting['start_url'] ?? null;
            $linkPaciente = $zoomMeeting['join_url'] ?? null;

            if ($linkDoutor && $linkPaciente) {
                // Criar a consulta no banco de dados
                $consulta = Consulta::create([
                    'doutor_cpf' => $request->input('doutor_cpf'),
                    'paciente_cpf' => $request->input('paciente_cpf'),
                    'data_hora' => $request->input('data_hora'),
                    'link_doutor' => $linkDoutor,
                    'link_paciente' => $linkPaciente,
                    'status' => 'pendente',
                ]);

                // slot não disponível
                $slot->update(['disponivel' => false]);

                return redirect()->route('paciente.consultas')->with('success', 'Consulta agendada com sucesso!');
            } else {
                return redirect()->back()->with('error', 'Erro ao criar reunião no Zoom.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao agendar consulta: ' . $e->getMessage());
        }
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
            $slot->paciente_cpf = null; 
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