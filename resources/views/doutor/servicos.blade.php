@extends('layouts.app_doutor')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Serviços Cadastrados</h1>

    @if($servicos->isEmpty())
        <div class="alert alert-warning" role="alert">
            Você ainda não cadastrou serviços.
        </div>
    @else
        <div class="row">
            @foreach($servicos as $servico)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $servico->titulo }}</h5>
                            <p class="card-text">{{ Str::limit($servico->descricao, 80) }}</p>
                            <ul class="list-unstyled">
                                <li><strong>Preço:</strong> R$ {{ number_format($servico->preco, 2, ',', '.') }}</li>
                                @foreach(json_decode($servico->periodos) as $periodo)
                                    <li><strong>Data:</strong> {{ $periodo->datas }}</li>
                                    <li><strong>Horário:</strong> {{ $periodo->hora_inicio }} até {{ $periodo->hora_fim }}</li>
                                @endforeach
                            </ul>
                            <!-- Botões de editar e excluir -->
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editarServicoModal-{{ $servico->id }}" data-id="{{ $servico->id }}"
                                data-titulo="{{ $servico->titulo }}" data-descricao="{{ $servico->descricao }}"
                                data-preco="{{ $servico->preco }}" data-periodos='@json(json_decode($servico->periodos))'>
                                <i class="bi bi-pencil"></i> Editar
                            </button>

                            <form action="{{ route('doutor.servicos.destroy', $servico->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Tem certeza que deseja excluir este serviço?')">
                                    <i class="bi bi-trash"></i> Excluir
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Botão para abrir o modal de criação -->
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#criarServicoModal">
        <i class="bi bi-plus-circle"></i> Cadastrar Novo Serviço
    </button>

    <!-- Modal para Criar Serviço -->
    <div class="modal fade" id="criarServicoModal" tabindex="-1" aria-labelledby="criarServicoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="criarServicoModalLabel">Cadastrar Novo Serviço</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('doutor.servicos.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="titulo">Título do Serviço</label>
                            <input type="text" name="titulo" id="titulo"
                                class="form-control @error('titulo') is-invalid @enderror" value="{{ old('titulo') }}"
                                required>
                            @error('titulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="descricao">Descrição</label>
                            <textarea name="descricao" id="descricao"
                                class="form-control @error('descricao') is-invalid @enderror"
                                rows="3">{{ old('descricao') }}</textarea>
                            @error('descricao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="preco">Preço</label>
                            <input type="number" name="preco" id="preco"
                                class="form-control @error('preco') is-invalid @enderror" value="{{ old('preco') }}"
                                required>
                            @error('preco')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="periodos">Períodos de Atendimento</label>
                            <div id="periodos">
                                @if (old('periodos'))
                                    @foreach (old('periodos') as $index => $periodo)
                                        <div class="periodo mb-3" id="periodo-{{ $index }}">
                                            <label for="datas-{{ $index }}">Selecione o Intervalo de Datas</label>
                                            <input type="text" id="datas-{{ $index }}" name="periodos[{{ $index }}][datas]"
                                                class="form-control flatpickr @error('periodos.' . $index . '.datas') is-invalid @enderror"
                                                value="{{ $periodo['datas'] }}" placeholder="Selecione as datas" required
                                                readonly>
                                            @error('periodos.' . $index . '.datas')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <input type="time" name="periodos[{{ $index }}][hora_inicio]"
                                                class="form-control mt-2 @error('periodos.' . $index . '.hora_inicio') is-invalid @enderror"
                                                value="{{ $periodo['hora_inicio'] }}" required>
                                            @error('periodos.' . $index . '.hora_inicio')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <input type="time" name="periodos[{{ $index }}][hora_fim]"
                                                class="form-control mt-2 @error('periodos.' . $index . '.hora_fim') is-invalid @enderror"
                                                value="{{ $periodo['hora_fim'] }}" required>
                                            @error('periodos.' . $index . '.hora_fim')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <button type="button" class="btn btn-danger btn-sm mt-2 remover-periodo">Excluir
                                                Período</button>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="periodo mb-3" id="periodo-0">
                                        <label for="datas-0">Selecione o Intervalo de Datas</label>
                                        <input type="text" id="datas-0" name="periodos[0][datas]"
                                            class="form-control flatpickr @error('periodos.0.datas') is-invalid @enderror"
                                            value="{{ old('periodos.0.datas') }}" placeholder="Selecione as datas" required
                                            readonly>
                                        @error('periodos.0.datas')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <input type="time" name="periodos[0][hora_inicio]"
                                            class="form-control mt-2 @error('periodos.0.hora_inicio') is-invalid @enderror"
                                            value="{{ old('periodos.0.hora_inicio') }}" required>
                                        @error('periodos.0.hora_inicio')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <input type="time" name="periodos[0][hora_fim]"
                                            class="form-control mt-2 @error('periodos.0.hora_fim') is-invalid @enderror"
                                            value="{{ old('periodos.0.hora_fim') }}" required>
                                        @error('periodos.0.hora_fim')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <button type="button" class="btn btn-danger btn-sm mt-2 remover-periodo">Excluir
                                            Período</button>
                                    </div>
                                @endif
                            </div>
                            <button type="button" id="adicionarPeriodo" class="btn btn-link">Adicionar Período</button>
                        </div>

                        @if ($errors->has('periodos'))
                            <div class="alert alert-danger">
                                {{ $errors->first('periodos') }}
                            </div>
                        @endif

                        <button type="submit" class="btn btn-primary w-100">Salvar Serviço</button>
                    </form>


                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Editar Serviço -->
    @foreach($servicos as $servico)
        <div class="modal fade" id="editarServicoModal-{{ $servico->id }}" tabindex="-1"
            aria-labelledby="editarServicoModalLabel-{{ $servico->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarServicoModalLabel-{{ $servico->id }}">Editar Serviço</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('doutor.servicos.update', $servico->id) }}" method="POST"
                            id="editarServicoForm-{{ $servico->id }}">
                            @csrf
                            @method('PUT')

                            <div class="form-group mb-3">
                                <label for="titulo">Título do Serviço</label>
                                <input type="text" name="titulo" id="titulo-{{ $servico->id }}" class="form-control"
                                    value="{{ $servico->titulo }}" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="descricao">Descrição</label>
                                <textarea name="descricao" id="descricao-{{ $servico->id }}" class="form-control"
                                    rows="3">{{ $servico->descricao }}</textarea>
                            </div>

                            <div class="form-group mb-3">
                                <label for="preco">Preço</label>
                                <input type="number" name="preco" id="preco-{{ $servico->id }}" class="form-control"
                                    value="{{ $servico->preco }}" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="periodos">Períodos de Atendimento</label>
                                <div id="periodos-{{ $servico->id }}">
                                    @foreach(json_decode($servico->periodos) as $index => $periodo)
                                        <div class="periodo mb-3" id="periodo-{{ $index }}">
                                            <label for="datas-{{ $index }}">Intervalo de Datas</label>
                                            <input type="text" id="datas-{{ $index }}" name="periodos[{{ $index }}][datas]"
                                                class="form-control flatpickr" value="{{ $periodo->datas }}" required readonly>
                                            <input type="time" name="periodos[{{ $index }}][hora_inicio]"
                                                class="form-control mt-2" value="{{ $periodo->hora_inicio }}" required>
                                            <input type="time" name="periodos[{{ $index }}][hora_fim]" class="form-control mt-2"
                                                value="{{ $periodo->hora_fim }}" required>
                                            <button type="button" class="btn btn-danger btn-sm mt-2 remover-periodo">Excluir
                                                Período</button>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" id="adicionarPeriodo-{{ $servico->id }}"
                                    class="btn btn-link">Adicionar Período</button>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Salvar Alterações</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Inicializar flatpickr para os campos de data
            flatpickr('.flatpickr', {
                mode: 'range',
                dateFormat: 'd/m/Y',
                locale: 'pt'
            });

            // Função para verificar se o período é válido
            function verificarSobreposicao(servicoId = null) {
                let periodos = [];
                const periodoContainers = servicoId ? document.querySelectorAll(`#periodos-${servicoId} .periodo`) : document.querySelectorAll('#periodos .periodo');

                periodoContainers.forEach(function (periodoElement) {
                    const data = periodoElement.querySelector('input[name*="datas"]').value;
                    const horaInicio = periodoElement.querySelector('input[name*="hora_inicio"]').value;
                    const horaFim = periodoElement.querySelector('input[name*="hora_fim"]').value;

                    // Aqui estamos coletando os dados para comparar com os outros períodos
                    periodos.push({ data, horaInicio, horaFim });
                });

                // Lógica para verificar sobreposição
                for (let i = 0; i < periodos.length; i++) {
                    for (let j = i + 1; j < periodos.length; j++) {
                        if (periodos[i].data === periodos[j].data) {
                            // Verifica se os horários se sobrepõem
                            if (
                                (periodos[i].horaInicio < periodos[j].horaFim && periodos[i].horaFim > periodos[j].horaInicio)
                            ) {
                                return false; // Se sobrepõe
                            }
                        }
                    }
                }

                return true; // Não há sobreposição
            }

            // Função para adicionar período no modal de criação e edição
            function adicionarPeriodo(servicoId = null) {
                const periodoIndex = servicoId ? `${servicoId}-${document.querySelectorAll(`#periodos-${servicoId} .periodo`).length}` : document.querySelectorAll('#periodos .periodo').length;
                const container = servicoId ? document.getElementById(`periodos-${servicoId}`) : document.getElementById('periodos');

                const novoPeriodoHTML = `
                        <div class="periodo mb-3" id="periodo-${periodoIndex}">
                            <label for="datas-${periodoIndex}">Selecione o Intervalo de Datas</label>
                            <input type="text" id="datas-${periodoIndex}" name="periodos[${periodoIndex}][datas]" class="form-control flatpickr" placeholder="Selecione as datas" required readonly>
                            <input type="time" name="periodos[${periodoIndex}][hora_inicio]" class="form-control mt-2" required>
                            <input type="time" name="periodos[${periodoIndex}][hora_fim]" class="form-control mt-2" required>
                            <button type="button" class="btn btn-danger btn-sm mt-2 remover-periodo">Excluir Período</button>
                        </div>
                    `;

                container.insertAdjacentHTML('beforeend', novoPeriodoHTML);
                flatpickr(`#datas-${periodoIndex}`, {
                    mode: 'range',
                    dateFormat: 'd/m/Y',
                    locale: 'pt'
                });

                // Verifica a sobreposição ao adicionar novo período
                if (!verificarSobreposicao(servicoId)) {
                    alert('Há sobreposição de horários. Por favor, ajuste as datas ou horários.');
                    // Opcional: pode remover o último período adicionado se houver sobreposição
                    document.getElementById(`periodo-${periodoIndex}`).remove();
                }
            }

            // Função para remover período
            function removerPeriodo(event) {
                const periodoElement = event.target.closest('.periodo');
                periodoElement.remove();
            }

            // Evento para adicionar período na tela de criação
            document.getElementById('adicionarPeriodo').addEventListener('click', function () {
                adicionarPeriodo();
            });

            // Evento para adicionar período na tela de edição
            document.querySelectorAll('[id^=adicionarPeriodo]').forEach(function (button) {
                button.addEventListener('click', function () {
                    const servicoId = button.id.split('-')[1];
                    adicionarPeriodo(servicoId);
                });
            });

            // Evento para remover período
            document.body.addEventListener('click', function (event) {
                if (event.target.classList.contains('remover-periodo')) {
                    removerPeriodo(event);
                }
            });
        });

    </script>
@endpush