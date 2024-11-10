@extends('layouts.app_doutor')

@section('content')
<div class="container">
    <h1>Meus Serviços</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Botão para abrir o modal de criação -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createServicoModal">
        Novo Serviço
    </button>

    <h2>Serviços Disponíveis</h2>
    @foreach($servicos as $servico)
        <div class="servico">
            <h3>{{ $servico->titulo }}</h3>
            <p>{{ $servico->descricao }}</p>
            <p><strong>Especialidade:</strong> {{ $servico->especialidade }}</p>
            <p><strong>Preço:</strong> R$ {{ number_format($servico->preco, 2, ',', '.') }}</p>

            <!-- Botões de edição e exclusão para o doutor -->
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editServicoModal{{ $servico->id }}">
                Editar
            </button>
            <form action="{{ route('doutor.servicos.destroy', $servico->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este serviço?')">Excluir</button>
            </form>
        </div>
        <hr>

        <!-- Modal para editar o serviço -->
        <div class="modal fade" id="editServicoModal{{ $servico->id }}" tabindex="-1" aria-labelledby="editServicoModalLabel{{ $servico->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editServicoModalLabel{{ $servico->id }}">Editar Serviço</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('doutor.servicos.update', $servico->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título do Serviço</label>
                                <input type="text" class="form-control" id="titulo" name="titulo" value="{{ $servico->titulo }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="descricao" class="form-label">Descrição</label>
                                <textarea class="form-control" id="descricao" name="descricao" rows="3" required>{{ $servico->descricao }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="especialidade" class="form-label">Especialidade</label>
                                <input type="text" class="form-control" id="especialidade" name="especialidade" value="{{ $servico->especialidade }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="preco" class="form-label">Preço</label>
                                <input type="number" class="form-control" id="preco" name="preco" value="{{ $servico->preco }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Atualizar Serviço</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
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
                    <button type="submit" class="btn btn-primary">Salvar Serviço</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
