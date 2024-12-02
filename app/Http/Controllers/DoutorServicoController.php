<?php

namespace App\Http\Controllers;

use App\Models\DoutorServico;
use App\Models\Slot;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DoutorServicoController extends Controller
{
    // Listar os serviços
    public function index()
    {
        $servicos = DoutorServico::all();
        return view('doutor.servicos', compact('servicos'));
    }

    // Criar novo serviço
    public function store(Request $request)
    {
        // Validação dos dados
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric',
            'periodos' => 'required|array',
            'periodos.*.datas' => 'required|string',
            'periodos.*.hora_inicio' => 'required|date_format:H:i',
            'periodos.*.hora_fim' => 'required|date_format:H:i|after:periodos.*.hora_inicio',
        ]);

        // Verificação de períodos duplicados
        $periodos = $request->periodos;

        foreach ($periodos as $key => $periodo) {
            foreach ($periodos as $compareKey => $comparePeriodo) {
                // Não compara o próprio item consigo mesmo
                if ($key != $compareKey) {
                    // Verifica se a data, hora de início e hora de fim são iguais
                    if (
                        $periodo['datas'] === $comparePeriodo['datas'] &&
                        $periodo['hora_inicio'] === $comparePeriodo['hora_inicio'] &&
                        $periodo['hora_fim'] === $comparePeriodo['hora_fim']
                    ) {
                        // Adiciona o erro de duplicação na coleção de erros
                        return redirect()->back()
                            ->withInput()
                            ->withErrors(['periodos' => 'Não é permitido cadastrar períodos duplicados.']);
                    }
                }
            }
        }

        // Processar os períodos antes de salvar
        $periodos = array_map(function ($periodo) {
            return [
                'datas' => $periodo['datas'],
                'hora_inicio' => $periodo['hora_inicio'],
                'hora_fim' => $periodo['hora_fim'],
            ];
        }, $request->periodos);

        // Salvar o serviço
        $servico = DoutorServico::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'preco' => $request->preco,
            'doutor_cpf' => auth()->user()->cpf,
            'periodos' => json_encode($periodos),  // Salva o período como JSON
        ]);

        // Gerar slots para cada período
        foreach ($periodos as $periodo) {
            $this->gerarSlotsPorPeriodo($servico, $periodo);
        }

        return redirect()->route('doutor.servicos');
    }


    public function gerarSlotsPorPeriodo($servico, $periodo)
    {
        // Verifica se o formato das datas está correto
        $datas = explode(" to ", $periodo['datas']);

        if (count($datas) === 1) {
            // Caso haja apenas uma data, a data_inicio e data_fim serão iguais
            $data_inicio = Carbon::createFromFormat('d/m/Y', $datas[0]);
            $data_fim = $data_inicio;  // A data final será igual à inicial
        } elseif (count($datas) === 2) {
            // Caso haja o intervalo de duas datas, atribui as duas datas corretamente
            $data_inicio = Carbon::createFromFormat('d/m/Y', $datas[0]);
            $data_fim = Carbon::createFromFormat('d/m/Y', $datas[1]);
        } else {
            throw new \Exception('Formato de datas inválido. A string deve conter "data_inicio" ou "data_inicio to data_fim".');
        }

        // Hora de início e fim
        $hora_inicio = Carbon::createFromFormat('H:i', $periodo['hora_inicio']);
        $hora_fim = Carbon::createFromFormat('H:i', $periodo['hora_fim']);

        // Loop para gerar os slots de cada dia no intervalo
        $data_atual = $data_inicio;
        while ($data_atual <= $data_fim) {
            // Para cada novo dia, resetar a hora de início para o valor inicial do período
            $hora_atual_inicio = $hora_inicio->copy();
            $hora_atual_fim = $hora_fim->copy();

            // Verifica se já existe um slot para esse horário e data
            $existe_slot = Slot::where('doutor_servico_id', $servico->id)
                ->whereDate('data_hora', $data_atual->toDateString())
                ->whereTime('data_hora', $hora_atual_inicio->toTimeString())
                ->exists();

            if ($existe_slot) {
                // Se o slot já existir, retorna com uma mensagem de erro
                return redirect()->route('doutor.servicos')
                    ->with('error', 'Já existe um horário disponível nessa data e horário.');
            }

            // Gera os slots para o dia atual
            $this->criarSlotsPorDia($servico, $data_atual, $hora_atual_inicio, $hora_atual_fim);

            // Avança para o próximo dia
            if ($data_atual < $data_fim) {
                $data_atual->addDay();
            } else {
                break;  // Se a data atual for igual à data final, finaliza o loop
            }
        }
    }





    public function criarSlotsPorDia(DoutorServico $servico, Carbon $data_dia, Carbon $hora_inicio, Carbon $hora_fim)
    {
        // Loop para criar slots de 30 minutos entre hora_inicio e hora_fim
        while ($hora_inicio < $hora_fim) {
            // Cria o slot para o dia atual
            Slot::create([
                'doutor_servico_id' => $servico->id,
                'data_hora' => $data_dia->copy()->setTimeFrom($hora_inicio),
                'disponivel' => true
            ]);

            // Avança 30 minutos
            $hora_inicio->addMinutes(30);
        }
    }

    // Editar serviço
    public function edit($id)
    {
        $servico = DoutorServico::findOrFail($id);
        return view('doutor.servicos', compact('servico'));
    }

    public function update(Request $request, $id)
    {
        $servico = DoutorServico::findOrFail($id);

        // Validação
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric',
            'periodos' => 'required|array',
        ]);

        // Salvando os períodos enviados
        $novos_periodos = $validated['periodos'];

        // Recupera os períodos antigos (do banco de dados)
        $periodos_antigos = json_decode($servico->periodos, true);

        // Excluindo os slots de períodos removidos
        foreach ($periodos_antigos as $periodo_antigo) {
            $existe_no_novo_periodo = false;

            foreach ($novos_periodos as $periodo_novo) {
                if (
                    $periodo_novo['datas'] === $periodo_antigo['datas'] &&
                    $periodo_novo['hora_inicio'] === $periodo_antigo['hora_inicio'] &&
                    $periodo_novo['hora_fim'] === $periodo_antigo['hora_fim']
                ) {
                    $existe_no_novo_periodo = true;
                    break;
                }
            }

            if (!$existe_no_novo_periodo) {
                // Se o período foi removido, exclua os slots relacionados a ele
                $this->removerSlotsPorPeriodo($servico, $periodo_antigo);
            }
        }

        // Atualizando o serviço
        $servico->update([
            'titulo' => $validated['titulo'],
            'descricao' => $validated['descricao'],
            'preco' => $validated['preco'],
            'periodos' => json_encode($novos_periodos),
        ]);

        // Excluir todos os slots antes de gerar os novos
        $this->removerTodosSlots($servico);

        // Gerar os slots para os períodos restantes (que foram adicionados ou modificados)
        foreach ($novos_periodos as $periodo) {
            $this->gerarSlotsPorPeriodo($servico, $periodo);
        }

        return redirect()->route('doutor.servicos')->with('success', 'Serviço atualizado com sucesso!');
    }


    public function removerTodosSlots(DoutorServico $servico)
    {
        // Remove todos os slots relacionados a esse serviço
        Slot::where('doutor_servico_id', $servico->id)->delete();
    }



    public function removerSlotsPorPeriodo(DoutorServico $servico, $periodo)
    {
        // Verifica se o formato das datas está correto
        $datas = explode(" to ", $periodo['datas']);

        if (count($datas) === 1) {
            // Caso haja apenas uma data, a data_inicio e data_fim serão iguais
            $data_inicio = Carbon::createFromFormat('d/m/Y', $datas[0]);
            $data_fim = $data_inicio;  // A data final será igual à inicial
        } elseif (count($datas) === 2) {
            // Caso haja o intervalo de duas datas, atribui as duas datas corretamente
            $data_inicio = Carbon::createFromFormat('d/m/Y', $datas[0]);
            $data_fim = Carbon::createFromFormat('d/m/Y', $datas[1]);
        } else {
            throw new \Exception('Formato de datas inválido. A string deve conter "data_inicio" ou "data_inicio to data_fim".');
        }

        // Hora de início e fim
        $hora_inicio = Carbon::createFromFormat('H:i', $periodo['hora_inicio']);
        $hora_fim = Carbon::createFromFormat('H:i', $periodo['hora_fim']);

        // Loop para excluir os slots de cada dia no intervalo
        $data_atual = $data_inicio;
        while ($data_atual <= $data_fim) {
            // Para cada novo dia, resetar a hora de início para o valor inicial do período
            $hora_atual_inicio = $hora_inicio->copy();
            $hora_atual_fim = $hora_fim->copy();

            // Excluir os slots para o dia atual
            $this->excluirSlotsPorDia($servico, $data_atual, $hora_atual_inicio, $hora_atual_fim);

            // Avança para o próximo dia
            if ($data_atual < $data_fim) {
                $data_atual->addDay();
            } else {
                break;  // Se a data atual for igual à data final, finaliza o loop
            }
        }
    }

    public function excluirSlotsPorDia(DoutorServico $servico, Carbon $data_dia, Carbon $hora_inicio, Carbon $hora_fim)
    {
        // Loop para excluir os slots de 30 minutos entre hora_inicio e hora_fim
        while ($hora_inicio < $hora_fim) {
            // Exclui o slot para o dia atual
            Slot::where('doutor_servico_id', $servico->id)
                ->whereDate('data_hora', $data_dia->toDateString())
                ->whereTime('data_hora', $hora_inicio->toTimeString())
                ->delete();

            // Avança 30 minutos
            $hora_inicio->addMinutes(30);
        }
    }


    public function destroy($id)
    {
        try {
            // Encontre o serviço pelo id
            $servico = DoutorServico::findOrFail($id);

            // Excluindo os slots relacionados a este serviço
            $servico->slots()->delete();

            // Agora exclui o serviço
            $servico->delete();

            return redirect()->route('doutor.servicos')->with('success', 'Serviço e seus slots excluídos com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('doutor.servicos')->with('error', 'Erro ao excluir serviço e seus slots!');
        }
    }
}