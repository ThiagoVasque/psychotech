<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Doutor;
use Illuminate\Support\Facades\Auth;
use App\Models\Doutor;
use App\Models\DoutorServico;
use Illuminate\Http\Request;
use App\Models\Slot;
use App\Models\Consulta;
use App\Services\ZoomService; 

class PacienteServicoController extends Controller
{
    protected $zoomService;

    public function __construct(ZoomService $zoomService)
    {
        $this->zoomService = $zoomService;
    }

    // Método para exibir os serviços dos doutores
    public function index()
    {
        $doutores = Doutor::with('servicos')->get();

        return view('paciente.servicos', compact('doutores'));
    }

    // Método para exibir os slots de um serviço
    public function exibirSlots(DoutorServico $servico)
    {
        // Obter os slots disponíveis para o serviço
        $slots = $servico->slots()->where('disponivel', true)->get();

        $doutor = Doutor::where('cpf', $servico->doutor_cpf)->first();

        return view('paciente.servicos_slots', compact('servico', 'slots', 'doutor'));
    }

    // Método para agendar o serviço
    public function agendar(Request $request, $servicoId, $slotId)
    {
        $servico = DoutorServico::findOrFail($servicoId);
        $slot = Slot::findOrFail($slotId);

        // Verificar se o slot está disponível
        if (!$slot->disponivel) {
            return back()->with('error', 'Esse horário já foi agendado.');
        }

        // Marcar o slot como ocupado
        $slot->disponivel = false;
        $slot->save();

        // Gerar os links para o Zoom
        $linksZoom = $this->gerarLinkZoom($slot->data_hora, $servico->doutor_cpf, $request->input('paciente_cpf'));

        if ($linksZoom) {
            // Criar a consulta (agendamento)
            $consulta = new Consulta();
            $consulta->doutor_cpf = $servico->doutor_cpf;  
            $consulta->paciente_cpf = $request->input('paciente_cpf');
            $consulta->data_hora = $slot->data_hora;
            $consulta->link_doutor = $linksZoom['link_doutor'];
            $consulta->link_paciente = $linksZoom['link_paciente'];
            $consulta->status = 'pendente';  
            $consulta->save();

            return redirect()->route('paciente.consultas')->with('success', 'Consulta agendada com sucesso!');
        } else {
            return back()->with('error', 'Falha ao gerar o link do Zoom.');
        }
    }

    private function gerarLinkZoom($dataHora, $doutorCpf, $pacienteCpf)
    {
        // Preparar os dados para a reunião
        $meetingData = [
            'topic' => 'Consulta Telemedicina',
            'type' => 2, //reuniao agendada
            'start_time' => \Carbon\Carbon::parse($dataHora)->toISOString(), 
            'duration' => 30, 
            'settings' => [
                'host_video' => true,
                'participant_video' => true,
            ],
        ];

        try {
            // Criar a reunião no Zoom
            $meeting = $this->zoomService->createMeeting($meetingData);

            if (isset($meeting['start_url'])) {
                // Retorna os links para o doutor e paciente
                return [
                    'link_doutor' => $meeting['start_url'],  // Link do doutor
                    'link_paciente' => $meeting['join_url'], // Link do paciente
                ];
            }

            // Se falhar, retorna null
            return null;
        } catch (\Exception $e) {
            // Em caso de erro, retorna um erro
            return null;
        }
    }

}
