<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .brand-color {
            color: #6f42c1;
        }
        .container {
            max-width: 400px; /* Define a largura máxima do formulário */
            margin-top: 100px; /* Espaço superior para centralização */
        }
    </style>
</head>
<body>
    <x-navbar />
    <div class="container text-center">
        <h1 class="brand-color">Psychotech</h1> <!-- Logo do site -->
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label for="cpf" class="form-label">CPF</label>
                <input type="text" name="cpf" id="cpf" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Entrar</button>
        </form>
        <div class="mt-3">
            <a href="{{ route('password.request') }}">Esqueci minha senha?</a> <!-- Link para recuperação de senha -->
        </div>
        <div class="mt-2">
            <p>Não tem uma conta? <a href="{{ route('register') }}">Cadastre-se</a></p> <!-- Link para cadastro -->
        </div>
    </div>
</body>
</html>
