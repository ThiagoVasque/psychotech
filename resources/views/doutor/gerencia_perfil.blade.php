@extends('layouts.app_doutor')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">Gerenciar Perfil</div>

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

                    <form method="POST" action="{{ route('doutor.perfil.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Nome -->
                        <div class="form-group mb-4">
                            <label for="nome">Nome Completo</label>
                            <input type="text" name="nome" id="nome" class="form-control"
                                value="{{ old('nome', $doutor->nome) }}" required>
                        </div>

                        <!-- Telefone -->
                        <div class="form-group mb-4">
                            <label for="telefone">Telefone</label>
                            <input type="tel" name="telefone" id="telefone" class="form-control"
                                value="{{ old('telefone', $doutor->telefone) }}" required
                                pattern="^\(\d{2}\) \d{5}-\d{4}$" placeholder="(XX) XXXXX-XXXX">
                        </div>

                        <!-- E-mail -->
                        <div class="form-group mb-4">
                            <label for="email">E-mail</label>
                            <input type="email" name="email" id="email" class="form-control"
                                value="{{ old('email', $doutor->email) }}" required>
                        </div>

                        <!-- Endereço -->
                        <div class="step" id="step2">
                            <div class="form-group mb-4">
                                <label for="cep">CEP</label>
                                <input type="text" name="cep" id="cep" class="form-control" required
                                    value="{{ old('cep', $doutor->cep) }}" placeholder="Digite seu CEP" maxlength="10"
                                    pattern="\d{5}-\d{3}" autocomplete="off">
                            </div>

                            <div class="form-group mb-4">
                                <label for="bairro">Bairro</label>
                                <input type="text" name="bairro" id="bairro" class="form-control" required
                                    value="{{ old('bairro', $doutor->bairro) }}" placeholder="Digite seu bairro">
                            </div>

                            <div class="form-group mb-4">
                                <label for="logradouro">Logradouro</label>
                                <input type="text" name="logradouro" id="logradouro" class="form-control" required
                                    value="{{ old('logradouro', $doutor->logradouro) }}"/>
                            </div>

                            <div class="form-group mb-4">
                                <label for="numero">Número</label>
                                <input type="text" name="numero" id="numero" class="form-control" required
                                    value="{{ old('numero', $doutor->numero) }}" placeholder="Digite o número">
                            </div>

                            <div class="form-group mb-4">
                                <label for="complemento">Complemento</label>
                                <input type="text" name="complemento" id="complemento" class="form-control"
                                    value="{{ old('complemento', $doutor->complemento) }}"
                                    placeholder="Digite o complemento (opcional)">
                            </div>

                            <div class="form-group mb-4">
                                <label for="cidade">Cidade</label>
                                <input type="text" name="cidade" id="cidade" class="form-control" required
                                    value="{{ old('cidade', $doutor->cidade) }}" placeholder="Digite sua cidade">
                            </div>

                            <div class="form-group mb-4">
                                <label for="estado">Estado</label>
                                <input type="text" name="estado" id="estado" class="form-control" required
                                    value="{{ old('estado', $doutor->estado) }}" placeholder="Digite seu estado"
                                    maxlength="2" autocomplete="address-level1">
                            </div>
                        </div>

                        <!-- Botão de Enviar -->
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary btn-lg w-100">Atualizar Perfil</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
