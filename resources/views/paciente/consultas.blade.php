@extends('layouts.app_paciente')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Consultas</h2>

    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Doutor</th>
                <th>Data</th>
                <th>Link da Reunião</th>
            </tr>
        </thead>
        <tbody>
            @foreach($consultas as $consulta)
                <div class="consulta">
                    <h3>Consulta com Doutor {{ $consulta->doutor->nome }}</h3>
                    <p>Data e Hora: {{ $consulta->data_hora }}</p>
                    <p>Anotação: {{ $consulta->anotacao }}</p>

                    <p><strong>Link para a Videochamada:</strong></p>
                    <p><a href="{{ $consulta->link_paciente }}" target="_blank">Entrar na Videochamada (Paciente)</a></p>
                </div>
            @endforeach
        </tbody>
    </table>
</div>
@endsection