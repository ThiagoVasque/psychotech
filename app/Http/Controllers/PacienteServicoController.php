<?php

namespace App\Http\Controllers;

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
    public function index(Request $request)
    {
        $titulo = $request->input('titulo'); // Obter o título do serviço

        // Filtrar doutores com base no título do serviço, se o filtro for informado
        $doutores = Doutor::whereHas('servicos', function ($query) use ($titulo) {
            if ($titulo) {
                $query->where('titulo', 'like', '%' . $titulo . '%');
            }
        })->get();

        return view('paciente.servicos', compact('doutores'));
    }
    public function listaDoutores(Request $request)
    {
        $titulo = $request->input('titulo'); // Obter o título do serviço

        // Filtrar doutores com base no título do serviço, se o filtro for informado
        $doutores = Doutor::whereHas('servicos', function ($query) use ($titulo) {
            if ($titulo) {
                $query->where('titulo', 'like', '%' . $titulo . '%');
            }
        })->get();

        return view('paciente.servicos', compact('doutores'));
    }

    // Método para exibir os slots de um serviço
    public function exibirSlots(DoutorServico $servico)
    {
        // Excluir slots com horários passados
        Slot::where('data_hora', '<', now())->delete();

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
            $consulta->anotacao = $request->input('anotacao');
            $consulta->valor = $servico->preco; // Adiciona o valor do serviço
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
            'type' => 2,
            'start_time' => \Carbon\Carbon::parse($dataHora)->toISOString(),
            'duration' => 30,
            'settings' => [
                'host_video' => true,
                'participant_video' => true,
                'mute_upon_entry' => true,
                'join_before_host' => false,
                'participant_audio' => 'voip',
                'waiting_room' => false,
            ],
        ];

        try {
            // Criar a reunião no Zoom
            $meeting = $this->zoomService->createMeeting($meetingData);

            \Log::info('Resposta do Zoom: ', $meeting);

            if (isset($meeting['start_url']) && isset($meeting['join_url']) && isset($meeting['password'])) {
                // URL para o participante (paciente)
                $joinUrl = $meeting['join_url'];
                $meetingId = $meeting['id'];
                $password = $meeting['password'];

                $joinUrl = 'https://app.zoom.us/wc/' . $meetingId . '/join?fromPWA=1&pwd=' . urlencode($password);

                // Link para o doutor (host)
                $startUrl = 'https://app.zoom.us/wc/' . $meetingId . '/start?fromPWA=1&pwd=' . urlencode($password);

                // Retorna os links para o doutor e paciente
                return [
                    'link_doutor' => $startUrl,
                    'link_paciente' => $joinUrl,
                ];
            }

            // Se falhar, retorna null
            return null;
        } catch (\Exception $e) {
            \Log::error('Erro ao criar a reunião no Zoom', ['error' => $e->getMessage()]);
            return null;
        }
    }


}