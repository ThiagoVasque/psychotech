<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            margin: 0;
        }
        .register-form {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px; 
            margin: 5rem auto; 
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
    </style>
    <script>
        function toggleCrmField() {
            const role = document.getElementById('role').value;
            const crmField = document.getElementById('crm-field');
            crmField.style.display = (role === 'doctor') ? 'block' : 'none';
        }
    </script>
</head>
<body>

    <x-navbar />

    <div class="register-form">
        <h1>Registrar</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
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
            <div class="mb-3">
                <label for="role" class="form-label">Escolha: Doutor/Paciente</label>
                <select name="role" id="role" class="form-select" required onchange="toggleCrmField()">
                    <option value="patient">Paciente</option>
                    <option value="doctor">Doutor</option>
                </select>
            </div>
            <div class="mb-3" id="crm-field" style="display: none;">
                <label for="crm" class="form-label">CRM (Doutores apenas)</label>
                <input type="text" name="crm" id="crm" class="form-control">
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input type="text" name="nome" id="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="birthdate" class="form-label">Data de Nascimento</label>
                <input type="date" name="data_nascimento" id="birthdate" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="cep" class="form-label">CEP</label>
                <input type="text" name="cep" id="cep" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="cpf" class="form-label">CPF</label>
                <input type="text" name="cpf" id="cpf" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="bairro" class="form-label">Bairro</label>
                <input type="text" name="bairro" id="bairro" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="logradouro" class="form-label">Logradouro</label>
                <input type="text" name="logradouro" id="logradouro" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="numero" class="form-label">Número</label>
                <input type="text" name="numero" id="numero" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="complemento" class="form-label">Complemento</label>
                <input type="text" name="complemento" id="complemento" class="form-control">
            </div>
            <div class="mb-3">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="tel" name="telefone" id="telefone" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmação de Senha</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success w-100">Cadastrar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
