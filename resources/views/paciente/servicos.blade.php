@extends('layouts.app_paciente')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center fw-bold">Lista de Doutores</h1>

    <!-- Filtro por Título do Serviço -->
    <form method="GET" action="{{ route('paciente.servicos') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="titulo" class="form-control" placeholder="Buscar serviço pelo título"
                value="{{ request('titulo') }}">
            <button class="btn btn-primary" type="submit">Filtrar</button>
        </div>
    </form>

    <div class="row">
        @foreach ($doutores as $doutor)
            <!-- Verifica se o doutor possui serviços -->
            @if ($doutor->servicos->count() > 0)
                <div class="col-md-4 mb-4 d-flex align-items-stretch">
                    <div class="card shadow-sm border-light rounded w-100">
                        <div class="text-center mt-3">
                            <!-- Foto do doutor -->
                            <img src="{{ $doutor->foto_perfil ? asset('storage/' . $doutor->foto_perfil) : 'https://via.placeholder.com/150?text=Médico' }}"
                                class="img-fluid rounded-circle" alt="Imagem do Médico"
                                style="width: 100px; height: 100px; object-fit: cover;">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-center">{{ $doutor->nome }}</h5>
                            <p class="card-text text-center"><strong>Especialidade:</strong> {{ $doutor->especialidade }}</p>


                            <ul class="list-unstyled mt-3 flex-grow-1">
                                @foreach ($doutor->servicos as $servico)
                                    <h4>Serviço: {{ $servico->titulo }}</h4>
                                    <li class="mb-4">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6>Descrição: {{ $servico->descricao }} </h6>
                                            </div>
                                            <div>
                                                <span class="badge bg-info">R$
                                                    {{ number_format($servico->preco, 2, ',', '.') }}</span>
                                            </div>
                                        </div>

                                        <!-- Botão para exibir os horários disponíveis -->
                                        <a href="{{ route('paciente.servicos_slots', $servico->id) }}"
                                            class="btn btn-primary btn-sm mt-2 w-100">
                                            Ver Disponibilidade
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
@endsection