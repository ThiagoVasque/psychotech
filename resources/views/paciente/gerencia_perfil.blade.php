@extends('layouts.app_paciente')

@section('title', 'Gerenciar Perfil')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Gerenciar Perfil</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('paciente.perfil.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Nome -->
                        <div class="form-group mb-3">
                            <label for="nome">Nome Completo</label>
                            <input type="text" name="nome" id="nome" class="form-control" 
                                value="{{ old('nome', $paciente->nome) }}" required>
                        </div>

                        <!-- Telefone -->
                        <div class="form-group mb-3">
                            <label for="telefone">Telefone</label>
                            <input type="text" name="telefone" id="telefone" class="form-control" 
                                value="{{ old('telefone', $paciente->telefone) }}" required>
                        </div>

                        <!-- E-mail -->
                        <div class="form-group mb-3">
                            <label for="email">E-mail</label>
                            <input type="email" name="email" id="email" class="form-control" 
                                value="{{ old('email', $paciente->email) }}" required>
                        </div>

                        <!-- Data de Nascimento -->
                        <div class="form-group mb-3">
                            <label for="data_nascimento">Data de Nascimento</label>
                            <input type="text" name="data_nascimento" id="data_nascimento" class="form-control"
                                value="{{ old('data_nascimento', $paciente->data_nascimento->format('d/m/Y')) }}" required>
                        </div>

                        <!-- Foto de Perfil -->
                        <div class="form-group mb-3">
                            <label for="foto_perfil">Foto de Perfil</label>
                            <input type="file" name="foto_perfil" id="foto_perfil" class="form-control" accept="image/*">
                        </div>

                        <!-- Botão de Enviar -->
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Atualizar Perfil</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
