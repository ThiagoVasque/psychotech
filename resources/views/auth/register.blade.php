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
        }
        .brand-color {
            color: #6f42c1;
        }
        .card-custom {
            border-radius: 15px;
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
            padding: 30px;
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
            padding: 10px 30px;
        }
    </style>
</head>
<body>

<x-navbar />

<!-- Form -->
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-8 col-lg-6">
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

                <form method="POST" action="{{ route('register') }}" id="registrationForm">
                    @csrf
                    
                    <!-- Informações Pessoais -->
                    <div class="step active" id="step1">
                        <div class="form-group">
                            <label for="role">Perfil</label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="">Escolha...</option>
                                <option value="doutor" {{ old('role') == 'doutor' ? 'selected' : '' }}>Doutor</option>
                                <option value="paciente" {{ old('role') == 'paciente' ? 'selected' : '' }}>Paciente</option>
                            </select>
                        </div>

                        <div class="form-group" id="crmField" style="display: {{ old('role') == 'doutor' ? 'block' : 'none' }};">
                            <label for="crm">CRM</label>
                            <input type="text" name="crm" id="crm" class="form-control" value="{{ old('crm') }}" placeholder="Digite seu CRM">
                        </div>

                        <div class="form-group">
                            <label for="cpf">CPF</label>
                            <input type="text" name="cpf" id="cpf" class="form-control" required value="{{ old('cpf') }}" placeholder="Digite seu CPF" maxlength="14">
                        </div>
                        <div class="form-group">
                            <label for="nome">Nome Completo</label>
                            <input type="text" name="nome" id="nome" class="form-control" required value="{{ old('nome') }}" placeholder="Digite seu nome">
                        </div>
                        <div class="form-group">
                            <label for="data_nascimento">Data de Nascimento</label>
                            <input type="text" name="data_nascimento" id="data_nascimento" class="form-control" required value="{{ old('data_nascimento') }}" placeholder="Dia/Mês/Ano">
                        </div>
                    </div>

                    <!-- Endereço -->
                    <div class="step" id="step2">
                        <div class="form-group">
                            <label for="cep">CEP</label>
                            <input type="text" name="cep" id="cep" class="form-control" required value="{{ old('cep') }}" placeholder="Digite seu CEP" maxlength="10">
                        </div>
                        <div class="form-group">
                            <label for="bairro">Bairro</label>
                            <input type="text" name="bairro" id="bairro" class="form-control" required value="{{ old('bairro') }}" placeholder="Digite seu bairro">
                        </div>
                        <div class="form-group">
                            <label for="logradouro">Logradouro</label>
                            <input type="text" name="logradouro" id="logradouro" class="form-control" required value="{{ old('logradouro') }}" placeholder="Digite seu logradouro">
                        </div>
                        <div class="form-group">
                            <label for="numero">Número</label>
                            <input type="text" name="numero" id="numero" class="form-control" required value="{{ old('numero') }}" placeholder="Digite o número">
                        </div>
                        <div class="form-group">
                            <label for="complemento">Complemento</label>
                            <input type="text" name="complemento" id="complemento" class="form-control" value="{{ old('complemento') }}" placeholder="Digite o complemento (opcional)">
                        </div>
                        <div class="form-group">
                            <label for="cidade">Cidade</label>
                            <input type="text" name="cidade" id="cidade" class="form-control" required value="{{ old('cidade') }}" placeholder="Digite sua cidade">
                        </div>
                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <input type="text" name="estado" id="estado" class="form-control" required value="{{ old('estado') }}" placeholder="Digite seu estado" maxlength="2">
                        </div>
                    </div>

                    <!-- Email e Senha (Última Etapa) -->
                    <div class="step" id="step3">
                        <div class="form-group">
                            <label for="telefone">Telefone</label>
                            <input type="text" name="telefone" id="telefone" class="form-control" required value="{{ old('telefone') }}" placeholder="Digite seu telefone">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required value="{{ old('email') }}" placeholder="Digite seu email">
                        </div>
                        <div class="form-group">
                            <label for="password">Senha</label>
                            <input type="password" name="password" id="password" class="form-control" required placeholder="Digite sua senha">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirme a Senha</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required placeholder="Confirme sua senha">
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
                    </div>

                    <div class="form-navigation">
                        <button type="button" class="btn btn-secondary" id="prevBtn" style="display: none;">Anterior</button>
                        <button type="button" class="btn btn-primary" id="nextBtn">Próximo</button>
                        <button type="submit" class="btn btn-primary" style="display: none;" id="submitBtn">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Verifica se há erros e define em qual passo o formulário deve começar
    const hasErrors = {{ $errors->any() ? 'true' : 'false' }};
    let currentStep = hasErrors ? 3 : 1; // Começa no passo 3 se houver erros, senão começa no passo 1
    const totalSteps = 3;

    // Função que mostra o passo atual do formulário
    const showStep = (step) => {
        // Esconde todos os passos e mostra apenas o atual
        for (let i = 1; i <= totalSteps; i++) {
            document.getElementById('step' + i).classList.remove('active');
        }
        document.getElementById('step' + step).classList.add('active');

        // Controla a visibilidade dos botões "Anterior", "Próximo" e "Registrar"
        document.getElementById('prevBtn').style.display = step === 1 ? 'none' : 'inline';
        document.getElementById('nextBtn').style.display = step === totalSteps ? 'none' : 'inline';
        document.getElementById('submitBtn').style.display = step === totalSteps ? 'inline' : 'none';
    };

    // Avança para o próximo passo
    document.getElementById('nextBtn').onclick = () => {
        if (currentStep < totalSteps) {
            currentStep++;
            showStep(currentStep);
        }
    };

    // Volta para o passo anterior
    document.getElementById('prevBtn').onclick = () => {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    };

    // Função de máscaras e comportamentos ao carregar a página
    $(document).ready(function () {
        // Máscaras para CPF, Data de Nascimento, CEP e Telefone
        $('#cpf').mask('000.000.000-00');
        $('#data_nascimento').mask('00/00/0000');
        $('#cep').mask('00000-000');
        $('#telefone').mask('(00) 00000-0000');

        // Quando o formulário for submetido, converta a data para o formato correto
        $('#registrationForm').submit(function () {
            var dataNascimento = $('#data_nascimento').val();
            if (dataNascimento) {
                // Converte de DD/MM/YYYY para YYYY-MM-DD
                var partes = dataNascimento.split('/');
                var dataFormatada = partes[2] + '-' + partes[1] + '-' + partes[0];
                $('#data_nascimento').val(dataFormatada);
            }
        });

        // Exibe o campo CRM quando o perfil selecionado é "Doutor"
        $('#role').change(function() {
            if ($(this).val() === 'doutor') {
                $('#crmField').show();
            } else {
                $('#crmField').hide();
            }
        }).trigger('change'); // Exibe/esconde o campo CRM conforme o perfil já selecionado ao carregar a página

        // Preenche o endereço automaticamente ao informar um CEP válido
        $('#cep').on('blur', function() {
            const cep = $(this).val().replace(/\D/g, ''); // Remove qualquer caracter não numérico
            if (cep.length === 8) { // Verifica se o CEP possui 8 dígitos
                $.getJSON(`https://viacep.com.br/ws/${cep}/json/`, function(data) {
                    if (data.erro) {
                        alert('CEP não encontrado'); // Mostra alerta se o CEP não for encontrado
                    } else {
                        // Preenche os campos de endereço com os dados
                        $('#logradouro').val(data.logradouro);
                        $('#bairro').val(data.bairro);
                        $('#cidade').val(data.localidade);
                        $('#estado').val(data.uf);
                    }
                });
            }
        });
    });

    // Mostra o passo inicial do formulário
    showStep(currentStep);
</script>


</body>
</html>
