@extends('layouts.app_doutor')

@section('content')
<div class="container">
    <h1>Minhas Sessões</h1>

    <!-- Botão para criar novo serviço -->
    <div class="mb-3">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createServicoModal">
            Criar Novo Serviço
        </button>
    </div>

    <!-- Modal para criação de novo serviço -->
    <div class="modal fade" id="createServicoModal" tabindex="-1" aria-labelledby="createServicoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createServicoModalLabel">Criar Novo Serviço</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('doutor.servicos.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título do Serviço</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" required>
                        </div>
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="especialidade" class="form-label">Especialidade</label>
                            <input type="text" class="form-control" id="especialidade" name="especialidade" required>
                        </div>
                        <div class="mb-3">
                            <label for="preco" class="form-label">Preço</label>
                            <input type="number" class="form-control" id="preco" name="preco" required>
                        </div>

                        <!-- Botão para configurar disponibilidades -->
                        <div class="mb-3">
                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#agendaModal">
                                Configurar Disponibilidade
                            </button>
                        </div>

                        <button type="submit" class="btn btn-primary">Salvar Serviço</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para configurar disponibilidade -->
    <div class="modal fade" id="agendaModal" tabindex="-1" aria-labelledby="agendaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agendaModalLabel">Configurar Disponibilidade</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h2>Selecione os horários disponíveis</h2>
                    <div id="agendaCalendar"></div>
                    <div id="horarioInput" style="display:none;">
                        <div class="mb-3">
                            <label for="hora_inicio" class="form-label">Hora de Início</label>
                            <input type="time" class="form-control" id="hora_inicio" name="hora_inicio">
                        </div>
                        <div class="mb-3">
                            <label for="hora_fim" class="form-label">Hora de Fim</label>
                            <input type="time" class="form-control" id="hora_fim" name="hora_fim">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" id="salvarDisponibilidade">Salvar Disponibilidade</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Verifica se o modal de agendamento de disponibilidade está sendo aberto
    const agendaModal = document.getElementById('agendaModal');
    agendaModal.addEventListener('shown.bs.modal', function () {
        // Inicializa o calendário dentro do modal
        var calendarEl = document.getElementById('agendaCalendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'pt-br', // Idioma em português
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            selectable: true, 
            editable: true,
            select: function(info) {
                // Ao selecionar um intervalo de datas, exibe o prompt para adicionar horário
                var dataInicio = info.startStr;
                var dataFim = info.endStr;

                // Exibe o formulário para selecionar horário
                document.getElementById('horarioInput').style.display = 'block';

                // Armazena as datas selecionadas para configurar o horário
                document.getElementById('salvarDisponibilidade').onclick = function() {
                    var horaInicio = document.getElementById('hora_inicio').value;
                    var horaFim = document.getElementById('hora_fim').value;

                    if (horaInicio && horaFim) {
                        // Formata as datas com os horários inseridos
                        var dataHoraInicio = new Date(dataInicio + 'T' + horaInicio);
                        var dataHoraFim = new Date(dataFim + 'T' + horaFim);

                        // Adiciona o evento ao calendário
                        calendar.addEvent({
                            title: 'Consulta Disponível',
                            start: dataHoraInicio,
                            end: dataHoraFim,
                            allDay: false,
                        });

                        // Esconde os campos de horário e limpa os valores
                        document.getElementById('horarioInput').style.display = 'none';
                        document.getElementById('hora_inicio').value = '';
                        document.getElementById('hora_fim').value = '';
                    } else {
                        alert('Por favor, defina o horário de início e fim.');
                    }
                };
            },
            events: [
                @foreach($agenda as $item)
                    @foreach($item as $horario)
                        {
                            title: 'Consulta Disponível',
                            start: '{{ $horario->data_hora_inicio }}',
                            end: '{{ $horario->data_hora_fim }}',
                            allDay: false
                        },
                    @endforeach
                @endforeach
            ]
        });
        calendar.render();
    });
});
</script>

@endsection
