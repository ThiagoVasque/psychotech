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

                    <form method="POST" action="" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="nome">Nome</label>
                            <input type="text" name="nome" id="nome" class="form-control" value="" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="telefone">Telefone</label>
                            <input type="text" name="telefone" id="telefone" class="form-control" value="" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="email">E-mail</label>
                            <input type="email" name="email" id="email" class="form-control" value="" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="cep">CEP</label>
                            <input type="text" name="cep" id="cep" class="form-control" value="" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="logradouro">Logradouro</label>
                            <input type="text" name="logradouro" id="logradouro" class="form-control" value="" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="numero">Número</label>
                            <input type="text" name="numero" id="numero" class="form-control" value="" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="complemento">Complemento</label>
                            <input type="text" name="complemento" id="complemento" class="form-control" value="">
                        </div>

                        <div class="form-group mb-3">
                            <label for="bairro">Bairro</label>
                            <input type="text" name="bairro" id="bairro" class="form-control" value="" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="cidade">Cidade</label>
                            <input type="text" name="cidade" id="cidade" class="form-control" value="" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="estado">Estado</label>
                            <input type="text" name="estado" id="estado" class="form-control" value="" maxlength="2" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="foto_perfil">Foto de Perfil</label>
                            <input type="file" name="foto_perfil" id="foto_perfil" class="form-control">
                          
                        </div>

                        <div class="form-group mb-3">
                            <label for="password">Senha (deixe em branco para manter a atual)</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>

                        <div class="form-group mb-3">
                            <label for="password_confirmation">Confirme a Senha</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary">Atualizar Perfil</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
