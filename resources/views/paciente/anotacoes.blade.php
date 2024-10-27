@extends('layouts.app')

@section('content')
    <h1>Anotações</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('paciente.storeAnotacao') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="entrada">Nova Anotação</label>
            <input type="text" class="form-control" id="entrada" name="entrada" required>
        </div>
        <button type="submit" class="btn btn-primary">Adicionar Anotação</button>
    </form>

    <hr>

    <h2>Suas Anotações</h2>
    <ul class="list-group">
        @foreach ($anotacoes as $anotacao)
            <li class="list-group-item">
                {{ $anotacao->entrada }} <br>
                <small>Criado em: {{ $anotacao->created_at->format('d/m/Y H:i') }}</small>
                <div class="float-right">
                    <a href="{{ route('paciente.editAnotacao', $anotacao->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('paciente.deleteAnotacao', $anotacao->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
@endsection
