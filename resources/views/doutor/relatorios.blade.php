@extends('layouts.app_doutor')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Relatórios</h2>

    <form action="{{ route('doutor.relatorios') }}" method="GET" class="mb-4">
        <div class="form-group">
            <label for="nome">Nome do Paciente</label>
            <input type="text" class="form-control" id="nome" name="nome" value="{{ request('nome') }}" placeholder="Digite o nome do paciente">
        </div>

        <div class="form-group d-flex align-items-center">
            <div>
                <label for="data_inicio">Data Início</label>
                <input type="date" class="form-control" id="data_inicio" name="data_inicio" value="{{ request('data_inicio') }}">
            </div>

            <div class="mx-2 mt-4">
                <span>entre</span>
            </div>

            <div>
                <label for="data_fim">Data Fim</label>
                <input type="date" class="form-control" id="data_fim" name="data_fim" value="{{ request('data_fim') }}">
            </div>

            <div class="ml-3 mt-4">
                <button type="submit" class="btn btn-primary">Pesquisar</button>
            </div>
        </div>
    </form>

    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Nome</th>
                <th>Idade</th>
                <th>Data da Consulta</th>
                <th>Observações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($consultas as $consulta)
                <tr>
                    <td>{{ $consulta->paciente->nome }}</td>
                    <td>{{ \Carbon\Carbon::parse($consulta->paciente->data_nascimento)->age }} anos</td>
                    <td>{{ \Carbon\Carbon::parse($consulta->data_hora)->format('d/m/Y H:i') }}</td>
                    <td>{{ $consulta->anotacao }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Nenhum resultado encontrado</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
