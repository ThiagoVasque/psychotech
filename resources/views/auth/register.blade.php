<!-- resources/views/auth/register.blade.php -->
@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PsychoTech - Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .brand-color {
            color: #6f42c1;
        }
        .btn-custom {
            background-color: #6f42c1;
            color: #fff;
        }
        .btn-custom:hover {
            background-color: #5a379f;
        }
        .card-custom {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-md-8 col-lg-6">
            <div class="card card-custom shadow">
                <div class="card-header text-center">
                    <h2 class="mb-0 brand-color">Registrar</h2>
                </div>
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

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group">
                            <label for="role">Perfil</label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="">Escolha...</option>
                                <option value="doutor">Doutor</option>
                                <option value="paciente">Paciente</option>
                            </select>
                        </div>

                        <div class="form-group" id="crmField" style="display: none;">
                            <label for="crm">CRM</label>
                            <input type="text" name="crm" id="crm" class="form-control" placeholder="Digite seu CRM">
                        </div>

                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" name="nome" id="nome" class="form-control" required placeholder="Digite seu nome">
                        </div>

                        <div class="form-group">
                            <label for="data_nascimento">Data de Nascimento</label>
                            <input type="date" name="data_nascimento" id="data_nascimento" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="cep">CEP</label>
                            <input type="text" name="cep" id="cep" class="form-control" required placeholder="Digite seu CEP">
                        </div>

                        <div class="form-group">
                            <label for="cpf">CPF</label>
                            <input type="text" name="cpf" id="cpf" class="form-control" required placeholder="Digite seu CPF">
                        </div>

                        <div class="form-group">
                            <label for="bairro">Bairro</label>
                            <input type="text" name="bairro" id="bairro" class="form-control" required placeholder="Digite seu bairro">
                        </div>

                        <div class="form-group">
                            <label for="logradouro">Logradouro</label>
                            <input type="text" name="logradouro" id="logradouro" class="form-control" required placeholder="Digite seu logradouro">
                        </div>

                        <div class="form-group">
                            <label for="numero">Número</label>
                            <input type="text" name="numero" id="numero" class="form-control" required placeholder="Digite o número">
                        </div>

                        <div class="form-group">
                            <label for="complemento">Complemento</label>
                            <input type="text" name="complemento" id="complemento" class="form-control" placeholder="Digite o complemento (opcional)">
                        </div>

                        <div class="form-group">
                            <label for="telefone">Telefone</label>
                            <input type="text" name="telefone" id="telefone" class="form-control" required placeholder="Digite seu telefone">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required placeholder="Digite seu email">
                        </div>

                        <div class="form-group">
                            <label for="password">Senha</label>
                            <input type="password" name="password" id="password" class="form-control" required placeholder="Digite sua senha">
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirme a Senha</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required placeholder="Confirme sua senha">
                        </div>

                        <button type="submit" class="btn btn-custom btn-block">Registrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    @section('scripts')
    <script>
       
        document.getElementById('role').addEventListener('change', function() {
            const crmField = document.getElementById('crmField');
            crmField.style.display = this.value === 'doutor' ? 'block' : 'none';

            if (this.value === 'doutor') {
                setTimeout(() => {
                    document.getElementById('crm').focus();
                }, 0);
            }
        });
    </script>
    @endsection
</body>
</html>
@endsection
