@extends('layouts.app_paciente')

@section('content')
<div class="container py-5">
    <h1 class="text-center text-primary mb-4">Minhas Anotações</h1>

    @if (session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <!-- Botão para abrir o modal de adicionar nova anotação -->
    <div class="text-center mb-4">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addAnotacaoModal">
            Nova Anotação
        </button>
    </div>

    <h2 class="text-center mb-4">Lista de Anotações</h2>
    @foreach($anotacoes as $anotacao)
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-body">
                <h3 class="card-title text-primary">{{ $anotacao->titulo }}</h3>
                <p class="card-text">{{ $anotacao->texto }}</p>
                <p class="text-muted"><strong>Criado em:</strong> {{ $anotacao->created_at->format('d/m/Y H:i:s') }}</p>

                <div class="d-flex justify-content-between">
                    <!-- Botão para abrir o modal de edição -->
                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                        data-target="#editAnotacaoModal{{ $anotacao->id }}">
                        Editar
                    </button>

                    <!-- Botão de exclusão -->
                    <form action="{{ route('paciente.deleteDiario', $anotacao->id) }}" method="POST"
                        style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Tem certeza que deseja excluir esta anotação?')">Excluir</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal de edição -->
        <div class="modal fade" id="editAnotacaoModal{{ $anotacao->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editAnotacaoModalLabel{{ $anotacao->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAnotacaoModalLabel{{ $anotacao->id }}">Editar Anotação</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('paciente.updateDiario', $anotacao->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="titulo_{{ $anotacao->id }}">Título:</label>
                                <input type="text" class="form-control" id="titulo_{{ $anotacao->id }}" name="titulo"
                                    value="{{ $anotacao->titulo }}" required>
                            </div>
                            <div class="form-group">
                                <label for="texto_{{ $anotacao->id }}">Texto:</label>
                                <textarea class="form-control" id="texto_{{ $anotacao->id }}" name="texto" rows="2"
                                    required>{{ $anotacao->texto }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Atualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    @endforeach
</div>

<!-- Modal para adicionar nova anotação -->
<div class="modal fade" id="addAnotacaoModal" tabindex="-1" role="dialog" aria-labelledby="addAnotacaoModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAnotacaoModalLabel">Nova Anotação</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('paciente.storeDiario') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="titulo">Título:</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" required>
                    </div>
                    <div class="form-group">
                        <label for="texto">Texto:</label>
                        <textarea class="form-control" id="texto" name="texto" rows="2" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Adicionar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function () {
    });
</script>
@endsection