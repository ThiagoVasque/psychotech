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
                        <th>Anotações</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($consultas as $consulta)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($consulta->data_hora)->format('d/m/Y H:i') }}</td>
                            <td>{{ $consulta->doutor->nome ?? 'Doutor não encontrado' }}</td>
                            <td>{{ $consulta->anotacao ?? 'Nenhuma anotação' }}</td>
                            <td>
                                <a href="{{ $consulta->link_paciente }}" class="btn btn-success" target="_blank">
                                    Iniciar Videochamada
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<!-- Adicionando estilos personalizados -->
<style>
    .table {
        margin-top: 20px;
        background-color: #f8f9fa;
    }

    .table th, .table td {
        text-align: center;
        vertical-align: middle;
    }

    .btn {
        width: 100%;
        padding: 10px;
        font-size: 16px;
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }
</style>
@endsection
