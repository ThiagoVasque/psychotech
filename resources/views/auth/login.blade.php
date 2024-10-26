<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .brand-color {
            color: #6f42c1;
        }
        .container {
            max-width: 400px; 
            margin-top: 100px;
        }
        .btn-primary:hover {
            background-color: #5c2a91; /* Cor ao passar o mouse */
            border-color: #5c2a91;
        }
    </style>
</head>
<body>
    <x-navbar />
    <div class="container text-center">
        <h1 class="brand-color">Psychotech</h1>
        
        <!-- Mensagens de sucesso e erro -->
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

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label for="cpf" class="form-label">CPF</label>
                <input type="text" name="cpf" id="cpf" class="form-control" required autofocus>
                @error('cpf')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <input type="password" name="password" id="password" class="form-control" required>
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Entrar</button>
        </form>

        <div class="mt-3">
            <a href="{{ route('password.request') }}">Esqueci minha senha?</a>
        </div>
        <div class="mt-2">
            <p>Não tem uma conta? <a href="{{ route('register') }}">Cadastre-se</a></p>
        </div>
    </div>
    <script>
        // Adicione aqui qualquer script adicional, se necessário
    </script>
</body>
</html>
