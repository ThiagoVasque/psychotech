@extends('layouts.app_paciente')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">Disponibilidade do Serviço: {{ $servico->titulo }}</h1>

    <h4>Escolha um horário:</h4>
    <div class="list-group">
        @foreach ($slots as $slot)
            <div class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <p><strong>Data:</strong> {{ \Carbon\Carbon::parse($slot->data_hora)->format('d/m/Y') }}</p>
                    <p><strong>Horário:</strong> {{ \Carbon\Carbon::parse($slot->data_hora)->format('H:i') }} -
                        {{ \Carbon\Carbon::parse($slot->data_hora)->addMinutes(30)->format('H:i') }}
                    </p>
                </div>

                <form action="{{ route('paciente.servicos.agendar', ['servico' => $servico->id, 'slotId' => $slot->id]) }}"
                    method="POST">
                    @csrf
                    <input type="hidden" name="doutor_cpf" value="{{ $doutor->cpf }}">
                    <input type="hidden" name="paciente_cpf" value="{{ Auth::user()->cpf }}">
                    <button type="submit" class="btn btn-primary">Agendar</button>
                </form>
            </div>
        @endforeach
    </div>

    @if ($slots->isEmpty())
        <p class="text-center">Não há slots disponíveis para este serviço.</p>
    @endif
</div>
@endsection