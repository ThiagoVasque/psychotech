    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <style>
            body {
                background-color: #f8f9fa;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                margin: 0;
            }
            .container {
                max-width: 400px; 
                padding: 2rem;
                background-color: #ffffff;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                margin-top:140px
            }
            .brand-color {
                color: #6f42c1;
                font-weight: bold;
            }
            .btn-primary {
                background-color: #6f42c1;
                border-color: #6f42c1;
            }
            .btn-primary:hover {
                background-color: #5c2a91;
                border-color: #5c2a91;
            }
            .form-control {
                border-radius: 8px;
                border: 1px solid #ced4da;
            }
            .form-control:focus {
                box-shadow: 0 0 8px rgba(111, 66, 193, 0.2);
                border-color: #6f42c1;
            }
            .alert {
                border-radius: 8px;
                font-size: 0.9rem;
            }
            a {
                color: #6f42c1;
                text-decoration: none;
            }
            a:hover {
                text-decoration: underline;
                color: #5c2a91;
            }
            .form-label {
                font-weight: 500;
                color: #6c757d;
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
                <button type="submit" class="btn btn-primary w-100">Entrar</button>
            </form>

            <div class="mt-3">
                <a href="{{ route('password.request') }}">Esqueci minha senha?</a>
            </div>
            <div class="mt-2">
                <p>Não tem uma conta? <a href="{{ route('register') }}">Cadastre-se</a></p>
            </div>
        </div>
        
        <script>
            $(document).ready(function() {
                // Máscara para o CPF
                $('#cpf').mask('000.000.000-00', {reverse: true});
            });
        </script>
    </body>
    </html>
