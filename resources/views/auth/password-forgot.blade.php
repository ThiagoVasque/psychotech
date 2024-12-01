<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        .card-header {
            background-color: #6f42c1;
            color: white;
            border-radius: 15px 15px 0 0;
            text-align: center;
            padding: 20px;
        }

        .card-header h3 {
            margin: 0;
            font-weight: bold;
        }

        .card-body {
            padding: 30px;
        }

        .btn-primary {
            background-color: #6f42c1;
            border: none;
        }

        .btn-primary:hover {
            background-color: #5a35a1;
        }

        .form-control {
            height: 45px;
            border-radius: 10px;
        }

        .form-text {
            font-size: 14px;
            color: #6c757d;
        }

        .text-muted a {
            color: #6f42c1;
            text-decoration: none;
        }

        .text-muted a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="card">
        <div class="card-header">
            <h3>Recuperar Senha</h3>
        </div>
        <div class="card-body">
            <!-- Mensagem de sucesso -->
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Exibe erros -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                        placeholder="Digite seu email">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="form-text">Você receberá um link de redefinição de senha no seu email.</div>
                </div>

                <button type="submit" class="btn btn-primary w-100">Enviar Link de Recuperação</button>
            </form>

            <div class="text-center mt-4 text-muted">
                <a href="{{ route('login') }}">Voltar ao Login</a>
            </div>
        </div>
    </div>

</body>

</html>