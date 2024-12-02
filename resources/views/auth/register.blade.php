<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
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
    </style>
</head>

<body>

    <x-navbar />

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card shadow-lg border-0 rounded-lg mt-5 card-custom">
                <div class="card-header text-white text-center">
                    <h3 class="mb-0">Registrar</h3>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}" id="registrationForm"
                        enctype="multipart/form-data">
                        @csrf

                        <!-- Informações Pessoais -->
                        <div class="step active" id="step1">
                            <div class="form-group">
                                <label for="role">Perfil</label>
                                <select name="role" id="role" class="form-control" required>
                                    <option value="">Escolha...</option>
                                    <option value="doutor" {{ old('role') == 'doutor' ? 'selected' : '' }}>Doutor</option>
                                    <option value="paciente" {{ old('role') == 'paciente' ? 'selected' : '' }}>Paciente
                                    </option>
                                </select>
                            </div>

                            <div class="form-group" id="crmField"
                                style="display: {{ old('role') == 'doutor' ? 'block' : 'none' }};">
                                <label for="crm">CRM</label>
                                <input type="text" name="crm" id="crm" class="form-control" value="{{ old('crm') }}"
                                    placeholder="Digite seu CRM">
                            </div>

                            <div class="form-group" id="especialidadeField"
                                style="display: {{ old('role') == 'doutor' ? 'block' : 'none' }};">
                                <label for="especialidade">Especialidade</label>
                                <input type="text" name="especialidade" id="especialidade" class="form-control"
                                    value="{{ old('especialidade') }}" placeholder="Digite sua especialidade">
                            </div>

                            <div class="form-group">
                                <label for="cpf">CPF</label>
                                <input type="text" name="cpf" id="cpf" class="form-control" required
                                    value="{{ old('cpf') }}" placeholder="Digite seu CPF" maxlength="14">
                            </div>
                            <div class="form-group">
                                <label for="nome">Nome Completo</label>
                                <input type="text" name="nome" id="nome" class="form-control" required
                                    value="{{ old('nome') }}" placeholder="Digite seu nome">
                            </div>
                            <div class="form-group">
                                <label for="data_nascimento">Data de Nascimento</label>
                                <input type="text" name="data_nascimento" id="data_nascimento" class="form-control"
                                    required value="{{ old('data_nascimento') }}" placeholder="Dia/Mês/Ano">
                            </div>

                        </div>

                        <!-- Endereço -->
                        <div class="step" id="step2">
                            <div class="form-group">
                                <label for="cep">CEP</label>
                                <input type="text" name="cep" id="cep" class="form-control" required
                                    value="{{ old('cep') }}" placeholder="Digite seu CEP" maxlength="10">
                            </div>
                            <div class="form-group">
                                <label for="bairro">Bairro</label>
                                <input type="text" name="bairro" id="bairro" class="form-control" required
                                    value="{{ old('bairro') }}" placeholder="Digite seu bairro">
                            </div>
                            <div class="form-group">
                                <label for="logradouro">Logradouro</label>
                                <input type="text" name="logradouro" id="logradouro" class="form-control" required
                                    value="{{ old('logradouro') }}" placeholder="Digite seu logradouro">
                            </div>
                            <div class="form-group">
                                <label for="numero">Número</label>
                                <input type="text" name="numero" id="numero" class="form-control" required
                                    value="{{ old('numero') }}" placeholder="Digite o número">
                            </div>
                            <div class="form-group">
                                <label for="complemento">Complemento</label>
                                <input type="text" name="complemento" id="complemento" class="form-control"
                                    value="{{ old('complemento') }}" placeholder="Digite o complemento (opcional)">
                            </div>
                            <div class="form-group">
                                <label for="cidade">Cidade</label>
                                <input type="text" name="cidade" id="cidade" class="form-control" required
                                    value="{{ old('cidade') }}" placeholder="Digite sua cidade">
                            </div>
                            <div class="form-group">
                                <label for="estado">Estado</label>
                                <input type="text" name="estado" id="estado" class="form-control" required
                                    value="{{ old('estado') }}" placeholder="Digite seu estado" maxlength="2">
                            </div>
                        </div>

                        <!-- Email e Senha (Última Etapa) -->
                        <div class="step" id="step3">
                            <!-- Campo de Foto de Perfil -->
                            <div class="form-group">
                                <label for="foto_perfil">Foto de Perfil</label>
                                <input type="file" name="foto_perfil" id="foto_perfil" class="form-control"
                                    accept="image/*">
                            </div>
                            <div class="form-group">
                                <label for="telefone">Telefone</label>
                                <input type="text" name="telefone" id="telefone" class="form-control" required
                                    value="{{ old('telefone') }}" placeholder="Digite seu telefone">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" required
                                    value="{{ old('email') }}" placeholder="Digite seu email">
                            </div>
                            <div class="form-group">
                                <label for="password">Senha</label>
                                <input type="password" name="password" id="password" class="form-control" required
                                    placeholder="Digite sua senha">
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Confirme a Senha</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control" required placeholder="Confirme sua senha">
                            </div>
                            <div id="passwordCriteria" class="text-muted mb-3">
                                <ul>
                                    <li id="lengthCriteria">Mínimo de 8 caracteres</li>
                                    <li id="uppercaseCriteria">Pelo menos uma letra maiúscula</li>
                                    <li id="numberCriteria">Pelo menos um número</li>
                                    <li id="specialCharCriteria">Pelo menos um caractere especial</li>
                                </ul>
                            </div>

                        </div>

                        <!-- Exibindo os erros nesta etapa -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-navigation">
                            <button type="button" class="btn btn-secondary" id="prevButton">Anterior</button>
                            <button type="button" class="btn btn-primary" id="nextButton">Próximo</button>
                            <button type="submit" class="btn btn-success" id="submitButton"
                                style="display:none;">Cadastrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Máscara para CPF e outros campos
            $('#cpf').mask('000.000.000-00');
            $('#data_nascimento').mask('00/00/0000');
            $('#cep').mask('00000-000');
            $('#telefone').mask('(00) 00000-0000');

            // Lógica da senha e barra de progresso
            $('#password').on('input', function () {
                var password = $(this).val();

                // Critérios de senha
                var isLengthValid = password.length >= 8;
                var hasUppercase = /[A-Z]/.test(password);
                var hasNumber = /[0-9]/.test(password);
                var hasSpecialChar = /[^A-Za-z0-9]/.test(password);

                // Alterar cor das instruções com base nos critérios
                $('#lengthCriteria').toggleClass('text-success', isLengthValid);
                $('#uppercaseCriteria').toggleClass('text-success', hasUppercase);
                $('#numberCriteria').toggleClass('text-success', hasNumber);
                $('#specialCharCriteria').toggleClass('text-success', hasSpecialChar);
            });


            // Função para buscar o endereço via CEP
            $('#cep').on('blur', function () {
                var cep = $(this).val().replace(/\D/g, '');
                if (cep.length === 8) {
                    $.getJSON(`https://viacep.com.br/ws/${cep}/json/`, function (data) {
                        if (!data.erro) {
                            $('#logradouro').val(data.logradouro);
                            $('#bairro').val(data.bairro);
                            $('#cidade').val(data.localidade);
                            $('#estado').val(data.uf);
                        } else {
                            alert("CEP não encontrado.");
                        }
                    }).fail(function () {
                        alert("Erro ao buscar o CEP.");
                    });
                }
            });

            // Lógica para mostrar ou ocultar os campos CRM e Especialidade baseado no perfil
            $('#role').change(function () {
                var selectedRole = $(this).val();

                if (selectedRole === 'doutor') {
                    $('#crmField').show();
                    $('#especialidadeField').show();
                    $('#crm').prop('disabled', false); // Ativa o campo CRM
                    $('#especialidade').prop('disabled', false); // Ativa o campo Especialidade
                } else {
                    $('#crmField').hide();
                    $('#especialidadeField').hide();
                    $('#crm').prop('disabled', true); // Desativa o campo CRM
                    $('#especialidade').prop('disabled', true); // Desativa o campo Especialidade
                }
            });

            // Definindo o valor inicial do perfil
            $('#role').trigger('change');

            // Navegação entre os passos
            var currentStep = 1;
            var totalSteps = 3;

            function showStep(step) {
                $('.step').removeClass('active');
                $('#step' + step).addClass('active');
                $('#prevButton').toggle(step > 1);
                $('#nextButton').toggle(step < totalSteps);
                $('#submitButton').toggle(step === totalSteps);
            }

            $('#nextButton').click(function () {
                if (currentStep < totalSteps) {
                    currentStep++;
                    showStep(currentStep);
                }
            });

            $('#prevButton').click(function () {
                if (currentStep > 1) {
                    currentStep--;
                    showStep(currentStep);
                }
            });

            showStep(currentStep);
        });

    </script>

</body>

</html>''