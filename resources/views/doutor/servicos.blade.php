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
                                <li><strong>Especialidade:</strong> {{ $servico->especialidade }}</li>
                                <li><strong>Preço:</strong> R$ {{ number_format($servico->preco, 2, ',', '.') }}</li>
                                @foreach(json_decode($servico->periodos) as $periodo)
                                    <li><strong>Data:</strong> {{ $periodo->datas }} </li>
                                    <li><strong>Horário:</strong> {{ $periodo->hora_inicio }} até {{ $periodo->hora_fim }}</li>
                                @endforeach
                            </ul>
                            <!-- editar e excluir -->
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editarServicoModal" data-id="{{ $servico->id }}" data-titulo="{{ $servico->titulo }}" data-descricao="{{ $servico->descricao }}" data-preco="{{ $servico->preco }}" data-especialidade="{{ $servico->especialidade }}" data-periodos="{{ json_encode($servico->periodos) }}">
                                <i class="bi bi-pencil"></i> Editar
                            </button>
                            <form action="{{ route('doutor.servicos.destroy', $servico->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este serviço?')">
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
    <div class="modal fade" id="criarServicoModal" tabindex="-1" aria-labelledby="criarServicoModalLabel" aria-hidden="true">
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
                            <input type="text" name="titulo" id="titulo" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="descricao">Descrição</label>
                            <textarea name="descricao" id="descricao" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="preco">Preço</label>
                            <input type="number" name="preco" id="preco" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="periodos">Períodos de Atendimento</label>
                            <div id="periodos">
                                <div class="periodo mb-3" id="periodo-0">
                                    <label for="datas-0">Selecione o Intervalo de Datas</label>
                                    <input type="text" id="datas-0" name="periodos[0][datas]"
                                        class="form-control flatpickr" placeholder="Selecione as datas" required
                                        readonly>
                                    <input type="time" name="periodos[0][hora_inicio]" class="form-control mt-2"
                                        required>
                                    <input type="time" name="periodos[0][hora_fim]" class="form-control mt-2" required>
                                </div>
                            </div>
                            <button type="button" id="adicionarPeriodo" class="btn btn-link">Adicionar Período</button>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Salvar Serviço</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Editar Serviço -->
    <div class="modal fade" id="editarServicoModal" tabindex="-1" aria-labelledby="editarServicoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarServicoModalLabel">Editar Serviço</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editarServicoForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="servicoId">
                        <div class="form-group mb-3">
                            <label for="titulo">Título do Serviço</label>
                            <input type="text" name="titulo" id="editarTitulo" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="descricao">Descrição</label>
                            <textarea name="descricao" id="editarDescricao" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="preco">Preço</label>
                            <input type="number" name="preco" id="editarPreco" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="periodos">Períodos de Atendimento</label>
                            <div id="editarPeriodos">
                            </div>
                            <button type="button" id="editarAdicionarPeriodo" class="btn btn-link">Adicionar Período</button>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Salvar Alterações</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <!-- Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Inicializa o flatpickr nos campos de datas
            flatpickr(".flatpickr", {
                mode: "range",
                dateFormat: "d/m/Y",
                locale: "pt",
                minDate: "today", // Impede a seleção de datas passadas
            });

            // Lógica de edição de serviço
            const editarModal = document.getElementById('editarServicoModal');
            editarModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget; // Botão que acionou o modal
                const id = button.getAttribute('data-id');
                const titulo = button.getAttribute('data-titulo');
                const descricao = button.getAttribute('data-descricao');
                const preco = button.getAttribute('data-preco');
                const especialidade = button.getAttribute('data-especialidade');
                const periodos = JSON.parse(button.getAttribute('data-periodos'));

                // Preenche os campos do modal
                document.getElementById('servicoId').value = id;
                document.getElementById('editarTitulo').value = titulo;
                document.getElementById('editarDescricao').value = descricao;
                document.getElementById('editarPreco').value = preco;

                // Adiciona os períodos
                let periodosHTML = '';
                periodos.forEach((periodo, index) => {
                    periodosHTML += `
                    <div class="periodo mb-3" id="periodo-${index}">
                        <label for="datas-${index}">Intervalo de Datas</label>
                        <input type="text" name="periodos[${index}][datas]" id="datas-${index}" class="form-control flatpickr" value="${periodo.datas}" readonly>
                        <input type="time" name="periodos[${index}][hora_inicio]" class="form-control mt-2" value="${periodo.hora_inicio}">
                        <input type="time" name="periodos[${index}][hora_fim]" class="form-control mt-2" value="${periodo.hora_fim}">
                    </div>`;
                });

                document.getElementById('editarPeriodos').innerHTML = periodosHTML;

                // Reaplica o flatpickr aos novos campos
                flatpickr(".flatpickr", {
                    mode: "range",
                    dateFormat: "d/m/Y",
                    locale: "pt",
                    minDate: "today",
                });
            });

            // Lógica para adicionar períodos dinamicamente
            let periodoIndex = 1; // Inicia o índice para o novo período
            const adicionarPeriodoButton = document.getElementById('adicionarPeriodo');
            adicionarPeriodoButton.addEventListener('click', function () {
                const novoPeriodoHTML = `
                <div class="periodo mb-3" id="periodo-${periodoIndex}">
                    <label for="datas-${periodoIndex}">Intervalo de Datas</label>
                    <input type="text" name="periodos[${periodoIndex}][datas]" id="datas-${periodoIndex}" class="form-control flatpickr" placeholder="Selecione as datas" readonly>
                    <input type="time" name="periodos[${periodoIndex}][hora_inicio]" class="form-control mt-2">
                    <input type="time" name="periodos[${periodoIndex}][hora_fim]" class="form-control mt-2">
                </div>`;
                
                // Adiciona o novo período ao container
                document.getElementById('periodos').insertAdjacentHTML('beforeend', novoPeriodoHTML);

                // Reaplica o flatpickr no novo campo de data
                flatpickr(`#datas-${periodoIndex}`, {
                    mode: "range",
                    dateFormat: "d/m/Y",
                    locale: "pt",
                    minDate: "today",
                });

                periodoIndex++; // adiciona o próximo período
            });
        });
    </script>
@endpush

