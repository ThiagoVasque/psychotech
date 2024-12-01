@extends('layouts.app_doutor')

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
                        <th>Paciente</th>
                        <th>Anotações</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($consultas as $consulta)
                                <tr
                                    class="{{ \Carbon\Carbon::parse($consulta->data_hora)->addHours(2)->isPast() ? 'text-muted' : '' }}">
                                    <td>{{ \Carbon\Carbon::parse($consulta->data_hora)->format('d/m/Y H:i') }}</td>
                                    <td>{{ $consulta->paciente->nome ?? 'Paciente não encontrado' }}</td>
                                    <td>{{ $consulta->anotacao ?? 'Nenhuma anotação' }}</td>
                                    <td>
                                        @php
                                            $agora = \Carbon\Carbon::now();
                                            $dataConsulta = \Carbon\Carbon::parse($consulta->data_hora);
                                        @endphp

                                        @if($dataConsulta->lte($agora)) {{-- Verifica se a consulta já está liberada --}}
                                            <a href="{{ $consulta->link_doutor }}" class="btn btn-primary" target="_blank">
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

<style>
    .table {
        margin-top: 20px;
        background-color: #f8f9fa;
    }

    .table th,
    .table td {
        text-align: center;
        vertical-align: middle;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }
</style>
@endsection