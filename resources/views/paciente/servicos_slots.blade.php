@extends('layouts.app_paciente')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">Disponibilidade do Serviço: {{ $servico->titulo }}</h1>
    <p class="text-center text-muted mb-4">{{ $servico->descricao }}</p>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Preço:</strong> R$ {{ number_format($servico->preco, 2, ',', '.') }}</p>
            <p><strong>Doutor:</strong> {{ $doutor->nome }} | <strong>Especialidade:</strong>
                {{ $doutor->especialidade }}</p>
        </div>
    </div>

    @if ($slots->isEmpty())
        <div class="alert alert-info text-center">
            Não há horários disponíveis para este serviço no momento.
        </div>
    @else
        <h4 class="mb-3">Selecione uma data e horário:</h4>
        <div class="list-group">
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <strong>Atenção!</strong> {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @foreach ($slots->groupBy(function ($slot) {
                    return \Carbon\Carbon::parse($slot->data_hora)->format('d/m/Y');
                })->sortKeys() as $data => $horarios)
                    <div class="list-group-item">
                        <h5 class="mb-3">{{ $data }}</h5>
                        <div class="row">
                            @foreach ($horarios as $slot)
                                <div class="col-md-4 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <p><strong>Horário:</strong></p>
                                            <p>{{ \Carbon\Carbon::parse($slot->data_hora)->format('H:i') }} -
                                                {{ \Carbon\Carbon::parse($slot->data_hora)->addMinutes(30)->format('H:i') }}
                                            </p>
                                            <form
                                                action="{{ route('paciente.servicos.agendar', ['servico' => $servico->id, 'slotId' => $slot->id]) }}"
                                                method="POST">
                                                @csrf
                                                <input type="hidden" name="doutor_cpf" value="{{ $doutor->cpf }}">
                                                <input type="hidden" name="paciente_cpf"
                                                    value="{{ Auth::guard('paciente')->user()->cpf }}">

                                                <div class="mb-2">
                                                    <textarea name="anotacao" class="form-control" rows="2"
                                                        placeholder="Adicione uma observação (opcional)"></textarea>
                                                </div>

                                                <button type="submit" class="btn btn-success btn-sm">Agendar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@push('scripts')
    <script>
        // Ativa a funcionalidade de fechamento do alerta com o botão "X"
        const closeButtons = document.querySelectorAll('.close');
        closeButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                const alert = e.target.closest('.alert');
                alert.classList.add('fade');
                setTimeout(() => alert.remove(), 150); // Remove após animação de fade
            });
        });
    </script>
@endpush
