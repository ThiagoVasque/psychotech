@extends('layouts.app_paciente')

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
                                value="{{ old('nome', $paciente->nome) }}">
                        </div>

                        <!-- Telefone -->
                        <div class="form-group mb-3">
                            <label for="telefone">Telefone</label>
                            <input type="tel" name="telefone" id="telefone" class="form-control"
                                value="{{ old('telefone', $paciente->telefone) }}" placeholder="(XX) XXXXX-XXXX">
                        </div>

                        <!-- E-mail -->
                        <div class="form-group mb-3">
                            <label for="email">E-mail</label>
                            <input type="email" name="email" id="email" class="form-control"
                                value="{{ old('email', $paciente->email) }}">
                        </div>

                        <!-- Foto de Perfil -->
                        <div class="form-group">
                            <label for="foto_perfil">Foto de Perfil</label>
                            <input type="file" name="foto_perfil" id="foto_perfil" class="form-control"
                                accept="image/*">
                        </div>

                        <!-- Endereço -->
                        <div class="step" id="step2">
                            <div class="form-group mb-3">
                                <label for="cep">CEP</label>
                                <input type="text" name="cep" id="cep" class="form-control"
                                    value="{{ old('cep', $paciente->cep) }}" placeholder="Digite seu CEP">
                            </div>

                            <div class="form-group mb-3">
                                <label for="bairro">Bairro</label>
                                <input type="text" name="bairro" id="bairro" class="form-control"
                                    value="{{ old('bairro', $paciente->bairro) }}" placeholder="Digite seu bairro">
                            </div>

                            <div class="form-group mb-3">
                                <label for="logradouro">Logradouro</label>
                                <input type="text" name="logradouro" id="logradouro" class="form-control"
                                    value="{{ old('logradouro', $paciente->logradouro) }}"
                                    placeholder="Digite seu logradouro" autocomplete="address-line1">
                            </div>

                            <div class="form-group mb-3">
                                <label for="numero">Número</label>
                                <input type="text" name="numero" id="numero" class="form-control"
                                    value="{{ old('numero', $paciente->numero) }}" placeholder="Digite o número">
                            </div>

                            <div class="form-group mb-3">
                                <label for="complemento">Complemento</label>
                                <input type="text" name="complemento" id="complemento" class="form-control"
                                    value="{{ old('complemento', $paciente->complemento) }}"
                                    placeholder="Digite o complemento (opcional)" autocomplete="address-line2">
                            </div>

                            <div class="form-group mb-3">
                                <label for="cidade">Cidade</label>
                                <input type="text" name="cidade" id="cidade" class="form-control"
                                    value="{{ old('cidade', $paciente->cidade) }}" placeholder="Digite sua cidade">
                            </div>

                            <div class="form-group mb-3">
                                <label for="estado">Estado</label>
                                <input type="text" name="estado" id="estado" class="form-control"
                                    value="{{ old('estado', $paciente->estado) }}" placeholder="Digite seu estado"
                                    maxlength="2" autocomplete="address-level1">
                            </div>
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

<!-- Adicionar scripts para mascarar os campos -->

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
    $(document).ready(function () {
        // Aplicar máscara ao telefone
        $('#telefone').mask('(00) 00000-0000');

        // Aplicar máscara ao CEP
        $('#cep').mask('00000-000');

        // Buscar endereço pelo CEP usando a API do ViaCEP
        $('#cep').on('blur', function () {
            const cep = $(this).val().replace(/\D/g, ''); // Remover tudo que não for número

            if (cep.length === 8) { // Verifica se o CEP tem 8 dígitos
                $.getJSON(`https://viacep.com.br/ws/${cep}/json/`, function (data) {
                    if (!data.erro) {
                        $('#logradouro').val(data.logradouro);
                        $('#bairro').val(data.bairro);
                        $('#cidade').val(data.localidade);
                        $('#estado').val(data.uf);
                    } else {
                        alert('CEP não encontrado.');
                    }
                }).fail(function () {
                    alert('Erro ao buscar o CEP. Tente novamente.');
                });
            }
        });
    });
</script>
@endpush

@endsection
