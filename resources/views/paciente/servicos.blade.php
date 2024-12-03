@extends('layouts.app_paciente')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center fw-bold">Lista de Doutores</h1>

    <!-- Filtro por Título do Serviço e Especialidade -->
    <form method="GET" action="{{ route('paciente.servicos') }}" class="mb-4">
        <div class="row g-2">
            <div class="col-md-6">
                <input type="text" name="titulo" class="form-control" placeholder="Buscar serviço pelo título"
                    value="{{ request('titulo') }}">
            </div>
            <div class="col-md-4">
                <select name="especialidade" class="form-control">
                    <option value="">Todas as especialidades</option>
                    @foreach ($especialidades as $especialidade)
                        <option value="{{ $especialidade }}" {{ request('especialidade') == $especialidade ? 'selected' : '' }}>
                            {{ $especialidade }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100" type="submit">Filtrar</button>
            </div>
        </div>
    </form>

    <div class="row">
    @foreach ($doutores as $doutor)
        @foreach ($doutor->servicos as $servico)
            @php
                // Verifique se há horários disponíveis para o serviço
                $slots = $servico->slots()->where('data_hora', '>=', now())->get();
            @endphp

            @if ($slots->isNotEmpty())
                <div class="col-md-4 mb-4 d-flex align-items-stretch">
                    <div class="card shadow-sm border-light rounded w-100">
                        <div class="text-center mt-3">
                            <!-- Foto do doutor com link para abrir o modal -->
                            <a href="#" data-bs-toggle="modal" data-bs-target="#fotoModal{{ $doutor->cpf }}">
                                <img src="{{ $doutor->foto_perfil ? asset('storage/fotos_perfil/' . $doutor->foto_perfil) . '?v=' . time() : 'https://via.placeholder.com/150?text=Médico' }}"
                                    class="img-fluid rounded-circle" alt="Imagem do Médico"
                                    style="width: 100px; height: 100px; object-fit: cover;">
                            </a>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-center">Dr(a) {{ $doutor->nome }}</h5>
                            <p class="card-text text-center">{{ $doutor->especialidade }}</p>
                            <p class="card-text text-center"><strong>Tempo de consulta: 30 Minutos</strong>

                            <ul class="list-unstyled mt-3 flex-grow-1">
                                <h4>
                                    <p class="card-text text-center">{{ $servico->titulo }}</p>
                                </h4>
                                <li class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6>Descrição:
                                                {{ \Illuminate\Support\Str::limit($servico->descricao, 50, '...') }}
                                                <a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#descricaoModal{{ $servico->id }}" class="text-primary">Ler
                                                    mais</a>
                                            </h6>
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
                            </ul>

                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endforeach
</div>


<!-- Modal para exibir a foto em tamanho maior, vinculado ao doutor específico -->
@foreach ($doutores as $doutor)
   <!-- Modal para exibir a foto em tamanho maior, vinculado ao doutor específico -->
<div class="modal fade" id="fotoModal{{ $doutor->cpf }}" tabindex="-1" aria-labelledby="fotoModalLabel{{ $doutor->cpf }}"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fotoModalLabel{{ $doutor->cpf }}">Foto de Dr(a)
                    {{ $doutor->nome }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ $doutor->foto_perfil ? asset('storage/fotos_perfil/' . $doutor->foto_perfil) . '?v=' . time() : 'https://via.placeholder.com/150?text=Médico' }}"
                    class="img-fluid rounded" alt="Imagem do Médico">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection