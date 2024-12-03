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

    public function __construct(ZoomService $zoomService)
    {
        $this->zoomService = $zoomService;
    }

    public function index()
    {
        $paciente = Auth::guard('paciente')->user();

        if (!$paciente) {
            return redirect()->route('login')->withErrors('Você precisa estar autenticado como paciente.');
        }

        // Recupera todas as consultas do paciente
        $consultas = Consulta::where('paciente_cpf', $paciente->cpf)
        ->with('doutorServico') // Carrega a relação com o doutorServico
        ->get();
    

        // Atualiza status de consultas que já passaram de 2 horas
        foreach ($consultas as $consulta) {
            if ($consulta->status !== 'desabilitado' && \Carbon\Carbon::parse($consulta->data_hora)->addHours(2)->isPast()) {
                $consulta->status = 'desabilitado';
                $consulta->save();
            }
        }

        // Filtra consultas que não estão desabilitadas
        $consultas = $consultas->where('status', '!=', 'desabilitado');

        return view('paciente.consultas', compact('consultas'));
    }



    public function agendar(Request $request, $slotId)
    {
        $paciente = Auth::guard('paciente')->user();

        if (!$paciente) {
            return redirect()->route('login')->withErrors('Você precisa estar autenticado como paciente.');
        }

        $request->validate([
            'doutor_cpf' => 'required|exists:doutores,cpf',
            'paciente_cpf' => 'required|exists:pacientes,cpf',
            'data_hora' => 'required|date',
            'anotacao' => 'nullable|string|max:500',
        ]);

        $slot = Slot::findOrFail($slotId);

        if (!$slot->disponivel) {
            return redirect()->back()->with('error', 'Slot não disponível.');
        }

        // Preparar os dados para a reunião
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
                // Gerar o link completo para o paciente
                $linkPaciente = $this->formatLinkPaciente($linkPaciente);

                // Criar a consulta (agendamento)
                $consulta = Consulta::create([
                    'doutor_cpf' => $request->input('doutor_cpf'),
                    'paciente_cpf' => $request->input('paciente_cpf'),
                    'data_hora' => $request->input('data_hora'),
                    'anotacao' => $request->input('anotacao'), // Salvando anotação
                    'link_doutor' => $linkDoutor,
                    'link_paciente' => $linkPaciente,
                    'status' => 'pendente',
                ]);

                $slot->update(['disponivel' => false]);

                return redirect()->route('paciente.consultas')->with('success', 'Consulta agendada com sucesso!');
            } else {
                return redirect()->back()->with('error', 'Erro ao criar reunião no Zoom.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao agendar consulta: ' . $e->getMessage());
        }
    }

    private function formatLinkPaciente($link)
    {
        // Modificar o link do paciente para garantir que esteja formatado corretamente
        return str_replace('zoom.us/j/', 'zoom.us/wc/', $link);
    }

    public function cancelar($id)
    {
        $consulta = Consulta::find($id);

        if (!$consulta) {
            return response()->json([
                'status' => 'error',
                'message' => 'Consulta não encontrada.'
            ]);
        }

        $slot = Slot::where('data_hora', $consulta->data_hora)
            ->where('doutor_cpf', $consulta->doutor_cpf)
            ->first();

        if ($slot) {
            $slot->disponivel = true;
            $slot->paciente_cpf = null;
            $slot->save();
        }

        $consulta->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Consulta cancelada e slot liberado.'
        ]);
    }
}