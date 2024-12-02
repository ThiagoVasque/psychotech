@extends('layouts.app')

@section('content')
<x-navbar />

<style>
    body {
        background-color: #f8f9fa;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    .brand-color {
        color: #6f42c1;
    }

    .card-custom {
        border-radius: 15px;
        margin-top: 30px;
    }

    .card-header {
        background-color: #6f42c1;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-control {
        height: 45px;
        font-size: 16px;
    }

    .btn-block {
        padding: 12px;
        font-size: 16px;
    }

    .container {
        padding: 30px 15px;
    }

    .step {
        display: none;
    }

    .step.active {
        display: block;
    }

    .form-navigation {
        text-align: center;
        margin-top: 20px;
    }

    .form-navigation button {
        font-size: 16px;
        padding: 10px 20px;
    }

    .progress-bar {
        transition: width 0.5s;
        position: relative;
    }

    .progress-bar span {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-weight: bold;
    }

    /* Ajustes de Responsividade */
    @media (max-width: 768px) {
        .card-header {
            padding: 15px;
        }

        .form-group label {
            font-size: 14px;
        }

        .form-control {
            height: 40px;
            font-size: 14px;
        }

        .btn-block {
            font-size: 14px;
            padding: 10px;
        }
    }

    @media (max-width: 576px) {
        .card-header h3 {
            font-size: 20px;
        }

        .form-navigation button {
            font-size: 14px;
            padding: 8px 15px;
        }
    }

    .text-success {
        color: green !important;
    }

    .text-danger {
        color: red !important;
    }
</style>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card shadow-lg border-0 rounded-lg mt-5 card-custom">
            <div class="card-header text-white text-center" style="background-color: #6f42c1;">
                <h3 class="mb-0">Redefinir Senha</h3>
            </div>
            <div class="card-body">
                <!-- Exibe erros, se houver -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Formulário de redefinição de senha -->
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ request()->email }}">

                    <div class="form-group">
                        <label for="password">Nova Senha</label>
                        <input id="password" type="password" name="password" class="form-control" required
                            placeholder="Digite a nova senha">
                    </div>
                    <div class="form-group">
                        <label for="password-confirm">Confirmar Nova Senha</label>
                        <input id="password-confirm" type="password" name="password_confirmation" class="form-control"
                            required placeholder="Confirme a nova senha">
                    </div>

                    <!-- Critérios de senha -->
                    <div id="passwordCriteria" class="text-muted mb-3">
                        <ul>
                            <li id="lengthCriteria">Mínimo de 8 caracteres</li>
                            <li id="uppercaseCriteria">Pelo menos uma letra maiúscula</li>
                            <li id="numberCriteria">Pelo menos um número</li>
                            <li id="specialCharCriteria">Pelo menos um caractere especial</li>
                        </ul>
                    </div>

                    <button type="submit" class="btn btn-success btn-block">Redefinir Senha</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        $('#password').on('input', function () {
            var password = $(this).val();

            // Critérios de senha
            var isLengthValid = password.length >= 8;
            var hasUppercase = /[A-Z]/.test(password);
            var hasNumber = /[0-9]/.test(password);
            var hasSpecialChar = /[^A-Za-z0-9]/.test(password);

            // Alterar cor das instruções com base nos critérios
            $('#lengthCriteria').removeClass('text-danger text-success').addClass(isLengthValid ? 'text-success' : 'text-danger');
            $('#uppercaseCriteria').removeClass('text-danger text-success').addClass(hasUppercase ? 'text-success' : 'text-danger');
            $('#numberCriteria').removeClass('text-danger text-success').addClass(hasNumber ? 'text-success' : 'text-danger');
            $('#specialCharCriteria').removeClass('text-danger text-success').addClass(hasSpecialChar ? 'text-success' : 'text-danger');
        });
    });
</script>

@endsection
