@extends('layouts.app_doutor')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Meus Pacientes</h2>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Nome</th>
                <th>Idade</th>
                <th>Data da Próxima Consulta</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>...</td>
                <td>...</td>
                <td>...</td>
                <td><a href="#" class="btn btn-primary btn-sm">Ver detalhes</a></td>
            </tr>
            <tr>
                <td>...</td>
                <td>...</td>
                <td>...</td>
                <td><a href="#" class="btn btn-primary btn-sm">Ver detalhes</a></td>
            </tr>
            <tr>
                <td>...</td>
                <td>...</td>
                <td>...</td>
                <td><a href="#" class="btn btn-primary btn-sm">Ver detalhes</a></td>
            </tr>
        </tbody>
    </table>
</div>
@endsection