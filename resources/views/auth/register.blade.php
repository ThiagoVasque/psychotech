<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<x-navbar />

    <!-- Formulário -->
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0 rounded-lg mt-5 card-custom">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="mb-0">Registrar</h3>
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
                            <label for="cpf">CPF</label>
                            <input type="text" name="cpf" id="cpf" class="form-control" required placeholder="Digite seu CPF" maxlength="14">
                        </div>
                        <div class="form-group">
                            <label for="nome">Nome Completo</label>
                            <input type="text" name="nome" id="nome" class="form-control" required placeholder="Digite seu nome">
                        </div>
                        <div class="form-group">
                            <label for="data_nascimento">Data de Nascimento</label>
                            <input type="date" name="data_nascimento" id="data_nascimento" class="form-control" required>
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
                            <label for="cep">CEP</label>
                            <input type="text" name="cep" id="cep" class="form-control" required placeholder="Digite seu CEP" maxlength="10">
                        </div>
                        <div class="form-group">
                            <label for="cidade">Cidade</label>
                            <input type="text" name="cidade" id="cidade" class="form-control" required placeholder="Digite sua cidade">
                        </div>
                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <input type="text" name="estado" id="estado" class="form-control" required placeholder="Digite seu estado" maxlength="2">
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
                            <label for="password">Senha</label>
                            <input type="password" name="password" id="password" class="form-control" required placeholder="Digite sua senha">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirme a Senha</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required placeholder="Confirme sua senha">
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Registrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('role').addEventListener('change', function() {
            const crmField = document.getElementById('crmField');
            crmField.style.display = this.value === 'doutor' ? 'block' : 'none';
        });

        // Máscara para CPF
        document.getElementById('cpf').addEventListener('input', function() {
            this.value = this.value
                .replace(/\D/g, '') 
                .replace(/(\d{3})(\d)/, '$1.$2')
                .replace(/(\d{3})(\d)/, '$1.$2') 
                .replace(/(\d{3})(\d{1,2})$/, '$1-$2'); 
        });

        // Máscara para CEP
        document.getElementById('cep').addEventListener('input', function() {
            this.value = this.value
                .replace(/\D/g, '') 
                .replace(/(\d{5})(\d)/, '$1-$2'); 
        });

        // Busca endereço pelo CEP
        document.getElementById('cep').addEventListener('blur', function() {
            const cep = this.value.replace(/\D/g, ''); 
            if (cep.length === 8) {
                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.erro) {
                            document.getElementById('logradouro').value = data.logradouro || '';
                            document.getElementById('bairro').value = data.bairro || ''; 
                            document.getElementById('cidade').value = data.localidade || ''; 
                            document.getElementById('estado').value = data.uf || ''; 
                        } else {
                            alert('CEP não encontrado.');
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao buscar o CEP:', error);
                    });
            } else {
                alert('Por favor, insira um CEP válido.');
            }
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
