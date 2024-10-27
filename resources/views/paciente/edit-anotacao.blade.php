@extends('layouts.app')

@section('content')
    <h1>Editar Anotação</h1>

    <form action="{{ route('paciente.updateAnotacao', $anotacao->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="entrada">Anotação</label>
            <input type="text" class="form-control" id="entrada" name="entrada" value="{{ $anotacao->entrada }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Atualizar Anotação</button>
    </form>
@endsection
