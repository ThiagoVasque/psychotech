<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { background-color: #f8f9fa; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .container { max-width: 550px; }
        .card-custom { border-radius: 12px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1); }
        .card-header, .btn-primary { background-color: #6f42c1; border-color: #6f42c1; }
        .btn-primary:hover { background-color: #5c2a91; border-color: #5c2a91; }
        .form-control { border-radius: 8px; border: 1px solid #ced4da; }
    </style>
</head>
<body>
    <x-navbar />

    <div class="container">
        <div class="card shadow-lg border-0 rounded-lg mt-5 card-custom">
            <div class="card-header text-white text-center"><h3 class="mb-0">Registrar</h3></div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="role">Perfil</label>
                        <select name="role" id="role" class="form-control" required>
                            <option value="">Escolha...</option>
                            <option value="doutor">Doutor</option>
                            <option value="paciente">Paciente</option>
                        </select>
                    </div>
                    <div class="form-group mb-3" id="crmField" style="display: none;">
                        <label for="crm">CRM</label>
                        <input type="text" name="crm" id="crm" class="form-control" placeholder="Digite seu CRM">
                    </div>
                    <div class="form-group mb-3">
                        <label for="cpf">CPF</label>
                        <input type="text" name="cpf" id="cpf" class="form-control" required placeholder="Digite seu CPF" maxlength="14">
                    </div>
                    <div class="form-group mb-3">
                        <label for="nome">Nome Completo</label>
                        <input type="text" name="nome" id="nome" class="form-control" required placeholder="Digite seu nome">
                    </div>
                    <div class="form-group mb-3">
                        <label for="data_nascimento">Data de Nascimento</label>
                        <input type="date" name="data_nascimento" id="data_nascimento" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="telefone">Telefone</label>
                        <input type="text" name="telefone" id="telefone" class="form-control" required placeholder="Digite seu telefone">
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required placeholder="Digite seu email">
                    </div>
                    <div class="form-group mb-3">
                        <label for="cep">CEP</label>
                        <input type="text" name="cep" id="cep" class="form-control" required placeholder="Digite seu CEP" maxlength="10">
                    </div>
                    <div class="form-group mb-3">
                        <label for="cidade">Cidade</label>
                        <input type="text" name="cidade" id="cidade" class="form-control" required placeholder="Digite sua cidade">
                    </div>
                    <div class="form-group mb-3">
                        <label for="estado">Estado</label>
                        <input type="text" name="estado" id="estado" class="form-control" required placeholder="Digite seu estado" maxlength="2">
                    </div>
                    <div class="form-group mb-3">
                        <label for="password">Senha</label>
                        <input type="password" name="password" id="password" class="form-control" required placeholder="Digite sua senha">
                    </div>
                    <div class="form-group mb-3">
                        <label for="password_confirmation">Confirme a Senha</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required placeholder="Confirme sua senha">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block w-100">Registrar</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('role').addEventListener('change', function() {
            document.getElementById('crmField').style.display = this.value === 'doutor' ? 'block' : 'none';
        });
        const addMask = (id, mask) => document.getElementById(id).addEventListener('input', function() { this.value = mask(this.value) });
        addMask('cpf', val => val.replace(/\D/g, '').replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})(\d{1,2})$/, '$1-$2'));
        addMask('cep', val => val.replace(/\D/g, '').replace(/(\d{5})(\d)/, '$1-$2'));
    </script>
</body>
</html>
