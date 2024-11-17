@extends('layouts.app_paciente')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Detalhes da Reunião</h2>

    @if(isset($meeting))
        <div class="alert alert-success">
            <h4>Reunião criada com sucesso!</h4>
            <p><strong>Link do Doutor: </strong><a href="{{ $meeting['join_url'] }}" target="_blank">Acessar Reunião</a></p>
            <p><strong>Link do Paciente: </strong><a href="{{ $meeting['start_url'] }}" target="_blank">Acessar Reunião</a></p>
        </div>
    @elseif(isset($error))
        <div class="alert alert-danger">
            <p>{{ $error }}</p>
        </div>
    @endif
</div>
@endsection
