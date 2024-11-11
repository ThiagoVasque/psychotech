<?php

namespace App\Http\Controllers;

use App\Models\AgendaDoutor;
use App\Models\DoutorServico; // Importando o modelo DoutorServico
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoutorController extends Controller
{
    // Método para exibir a página inicial do doutor
    public function home()
    {
        return view('doutor.home');
    }

    public function pacientes()
    {
        return view ('doutor.pacientes');
    }

    // Método para exibir a lista de pacientes
    public function index()
    {
        $doutor = Auth::user(); // Pega o doutor logado
        
        // Carregar as agendas do doutor
        $agenda = AgendaDoutor::where('doutor_cpf', $doutor->cpf)->get();
        
        // Certifique-se de que a view 'doutor.servicos' existe e está esperando a variável 'agenda'
        return view('doutor.servicos', compact('agenda'));  
    }

    // Método para exibir as sessões e serviços do doutor
    public function sessoes()
    {
        $doutor = Auth::user();
        
        // Carregar as agendas e serviços do doutor
        $agenda = AgendaDoutor::where('doutor_cpf', $doutor->cpf)->get();
        $servicos = DoutorServico::where('doutor_cpf', $doutor->cpf)->get(); 
        
        return view('doutor.sessoes', compact('agenda', 'servicos', 'doutor'));  
    }
    public function addHorario(Request $request, $servicoId)
{
    $validated = $request->validate([
        'data_inicio' => 'required|date',
        'data_fim' => 'required|date',
        'horario_inicio' => 'required|date_format:H:i',
        'horario_fim' => 'required|date_format:H:i|after:horario_inicio',
    ]);

    // Criar o novo horário
    $horario = new Horario();
    $horario->servico_id = $servicoId;
    $horario->data_hora_inicio = $validated['data_inicio'] . ' ' . $validated['horario_inicio'];
    $horario->data_hora_fim = $validated['data_fim'] . ' ' . $validated['horario_fim'];
    $horario->save();

    return redirect()->route('doutor.sessoes')->with('success', 'Horário adicionado com sucesso!');
}


    // Método para gerar relatórios
    public function relatorios()
    {
        $doutor = Auth::user(); 
        return view('doutor.relatorios', compact('doutor'));
    }

    // Método para salvar nova agenda
    public function salvarAgenda(Request $request)
    {
        $doutor = Auth::user();
        
        // Validação dos dados recebidos
        $validated = $request->validate([
            'data_hora_inicio' => 'required|date|after:now',
            'data_hora_fim' => 'required|date|after:data_hora_inicio',
        ]);
        
        // Criar uma nova agenda
        $agenda = new AgendaDoutor();
        $agenda->doutor_cpf = $doutor->cpf; // Associando a agenda ao doutor logado
        $agenda->data_hora_inicio = $request->data_hora_inicio; // Data de início
        $agenda->data_hora_fim = $request->data_hora_fim; // Data de fim
        $agenda->status = 'disponível'; // Definindo status como "disponível"
        $agenda->save();
        
        return redirect()->route('doutor.sessoes')->with('success', 'Agenda criada com sucesso!');
    }

    // Método para exibir videoconferência
    public function videoconferencia()
    {
        $doutor = Auth::user(); 
        return view('doutor.videoconferencia', compact('doutor'));
    }
}
