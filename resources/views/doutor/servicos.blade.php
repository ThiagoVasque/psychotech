@extends('layouts.app_doutor')

@section('content')
<div class="container mb-5">

    <h1 class="mb-4 mt-5">Cadastrar Novo Serviço</h1>

    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <strong>Ops! Algo deu errado.</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="formServico" action="{{ route('doutor.servicos.store') }}" method="POST" class="mb-5">
        @csrf
        <input type="hidden" name="doutor_cpf" value="{{ auth()->user()->cpf }}">

        <div class="mb-3">
            <label for="titulo" class="form-label">Título do Serviço</label>
            <input type="text" name="titulo" class="form-control" id="titulo" placeholder="Título do Serviço"
                value="{{ old('titulo') }}" required>
        </div>

        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição do Serviço</label>
            <textarea name="descricao" class="form-control" id="descricao" placeholder="Descrição do Serviço"
                required>{{ old('descricao') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="especialidade" class="form-label">Especialidade</label>
            <input type="text" name="especialidade" class="form-control" id="especialidade" placeholder="Especialidade"
                value="{{ old('especialidade') }}" required>
        </div>

        <div class="mb-3">
            <label for="preco" class="form-label">Preço</label>
            <input type="number" name="preco" class="form-control" id="preco" placeholder="Preço"
                value="{{ old('preco') }}" required>
        </div>

        <div id="horarios-container" class="mb-3"></div>

        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#horarioModal">
            <i class="bi bi-calendar-plus"></i> Adicionar Período de Atendimento
        </button>

        <button type="submit" class="btn btn-success w-100">Cadastrar Serviço</button>
    </form>

    @if ($servicos->isEmpty())
        <div class="alert alert-warning">
            Você ainda não cadastrou nenhum serviço.
        </div>
    @else
        <div class="row">
            @foreach ($servicos as $servico)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">{{ $servico->titulo }}</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Descrição:</strong> {{ $servico->descricao }}</p>
                            <p><strong>Especialidade:</strong> {{ $servico->especialidade }}</p>
                            <p><strong>Preço:</strong> R$ {{ number_format($servico->preco, 2, ',', '.') }}</p>
                            <p><strong>Período:</strong> {{ $servico->data_inicio_periodo }} até
                                {{ $servico->data_fim_periodo }}</p>
                            <p><strong>Horário:</strong> das {{ $servico->hora_inicio }} às {{ $servico->hora_fim }}</p>

                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editModal" onclick="editService({{ $servico }})">Editar</button>

                            <form action="{{ route('doutor.servicos.destroy', $servico->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Modal para adicionar período de atendimento -->
    <div class="modal fade" id="horarioModal" tabindex="-1" aria-labelledby="horarioModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="horarioModalLabel">Adicionar Período de Atendimento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="data_inicio_periodo" class="form-label">Data de Início do Período</label>
                        <input type="date" class="form-control" id="data_inicio_periodo" required>
                    </div>
                    <div class="mb-3">
                        <label for="data_fim_periodo" class="form-label">Data de Fim do Período</label>
                        <input type="date" class="form-control" id="data_fim_periodo" required>
                    </div>
                    <div class="mb-3">
                        <label for="hora_inicio" class="form-label">Hora de Início</label>
                        <input type="time" class="form-control" id="hora_inicio" required>
                    </div>
                    <div class="mb-3">
                        <label for="hora_fim" class="form-label">Hora de Fim</label>
                        <input type="time" class="form-control" id="hora_fim" required>
                    </div>
                    <button type="button" id="addHorarioBtn" class="btn btn-primary w-100">Adicionar Período</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar serviço -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Serviço</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="mb-3">
                            <label for="edit_titulo" class="form-label">Título do Serviço</label>
                            <input type="text" name="titulo" id="edit_titulo" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_descricao" class="form-label">Descrição</label>
                            <textarea name="descricao" id="edit_descricao" class="form-control" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_especialidade" class="form-label">Especialidade</label>
                            <input type="text" name="especialidade" id="edit_especialidade" class="form-control"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_preco" class="form-label">Preço</label>
                            <input type="number" name="preco" id="edit_preco" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('addHorarioBtn').addEventListener('click', function () {
            const data_inicio_periodo = document.getElementById('data_inicio_periodo').value;
            const data_fim_periodo = document.getElementById('data_fim_periodo').value;
            const hora_inicio = document.getElementById('hora_inicio').value;
            const hora_fim = document.getElementById('hora_fim').value;

            // Verifica se todos os campos estão preenchidos
            if (!data_inicio_periodo || !data_fim_periodo || !hora_inicio || !hora_fim) {
                alert('Por favor, preencha todos os campos.');
                return;
            }

            // Conta o número atual de períodos adicionados
            const horariosContainer = document.getElementById('horarios-container');
            const index = horariosContainer.children.length;

            // Cria um novo elemento HTML para o período de atendimento com índice exclusivo
            const horarioHTML = `
        <div class="mb-3 horario-group">
            <div class="d-flex justify-content-between">
                <div>
                    <strong>Data de Início:</strong> ${data_inicio_periodo} <br>
                    <strong>Data de Fim:</strong> ${data_fim_periodo} <br>
                    <strong>Hora de Início:</strong> ${hora_inicio} <br>
                    <strong>Hora de Fim:</strong> ${hora_fim}
                </div>
                <button type="button" class="btn btn-danger btn-sm removeHorarioBtn">
                    <i class="bi bi-x-circle"></i> Remover
                </button>
            </div>
            <input type="hidden" name="agenda_horarios[${index}][data_inicio_periodo]" value="${data_inicio_periodo}">
            <input type="hidden" name="agenda_horarios[${index}][data_fim_periodo]" value="${data_fim_periodo}">
            <input type="hidden" name="agenda_horarios[${index}][hora_inicio]" value="${hora_inicio}">
            <input type="hidden" name="agenda_horarios[${index}][hora_fim]" value="${hora_fim}">
        </div>
    `;

            // Adiciona o novo período de atendimento no container
            horariosContainer.insertAdjacentHTML('beforeend', horarioHTML);

            // Limpa os campos do modal
            document.getElementById('data_inicio_periodo').value = '';
            document.getElementById('data_fim_periodo').value = '';
            document.getElementById('hora_inicio').value = '';
            document.getElementById('hora_fim').value = '';

            // Fecha o modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('horarioModal'));
            modal.hide();

            // Adiciona a funcionalidade de remover período
            document.querySelectorAll('.removeHorarioBtn').forEach(button => {
                button.addEventListener('click', function () {
                    this.closest('.horario-group').remove();
                });
            });
        });

        function editService(servico) {
            // Define os valores dos campos do modal de edição com os dados do serviço selecionado
            document.getElementById('edit_id').value = servico.id;
            document.getElementById('edit_titulo').value = servico.titulo;
            document.getElementById('edit_descricao').value = servico.descricao;
            document.getElementById('edit_especialidade').value = servico.especialidade;
            document.getElementById('edit_preco').value = servico.preco;

            // Atualiza a URL do formulário para apontar para a rota correta de edição
            document.getElementById('editForm').action = `/doutor/servicos/${servico.id}`;
        }


    </script>

</div>
@endsection