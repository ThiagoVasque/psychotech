@extends('layouts.app_paciente')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Minhas Consultas</h2>

    @if($consultas->isEmpty())
        <p>Você ainda não tem consultas agendadas.</p>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Data e Hora</th>
                        <th>Doutor</th>
                        <th>Serviço</th> <!-- Coluna para o nome do serviço -->
                        <th>Anotações</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($consultas as $consulta)
                                <tr
                                    class="{{ \Carbon\Carbon::parse($consulta->data_hora)->addHours(2)->isPast() ? 'text-muted' : '' }}">
                                    <td>{{ \Carbon\Carbon::parse($consulta->data_hora)->format('d/m/Y H:i') }}</td>
                                    <td>
                                        {{ $consulta->doutor->nome ?? 'Doutor não encontrado' }}
                                        - {{ $consulta->doutor->especialidade ?? 'Especialidade não encontrada' }}
                                    </td>
                                    <td>{{ $consulta->doutorServico->titulo ?? 'Serviço não encontrado' }}</td>


                                    <!-- Exibe o nome do serviço -->
                                    <td>{{ $consulta->anotacao ?? 'Nenhuma anotação' }}</td>
                                    <td>
                                        @php
                                            $agora = \Carbon\Carbon::now();
                                            $dataConsulta = \Carbon\Carbon::parse($consulta->data_hora);
                                        @endphp

                                        @if($dataConsulta->lte($agora))
                                            <a href="{{ $consulta->link_paciente }}" class="btn btn-primary" target="_blank">
                                                Iniciar Videochamada
                                            </a>
                                        @else
                                            <button class="btn btn-secondary" disabled>
                                                Aguardando Horário
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection