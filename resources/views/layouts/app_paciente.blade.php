<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Paciente</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh; 
        }

        .container {
            margin-left: 250px; 
            padding-top: 20px;
            flex: 1;
        }

        footer {
            background-color: #821AD1;
            padding: 15px 0;
            width: 100%;
            position: relative;
            bottom: 0;
        }

        footer .container {
            max-width: 1140px;
            margin: 0 auto;
        }

        footer a {
            color: #fff;
            text-decoration: none;
            font-size: 20px;
        }

        footer a:hover {
            color: #ccc;
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light flex-column" style="width: 250px; height: 100vh; position: fixed; overflow-y: auto; box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);">
            <div class="text-center mb-4 mt-3">
                <h5>Olá</h5>
                @if(auth()->check())
                    <h3>{{ auth()->user()->nome }}</h3>
                    <small class="text-muted">{{ ucfirst(auth()->user()->role) }}</small>
                @else
                    <h3>Usuário não autenticado</h3>
                @endif
            </div>

            <ul class="navbar-nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('paciente.home') }}">
                        <i class="fas fa-home"></i> Início
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('paciente.servicos') }}">
                        <i class="fas fa-user-md"></i> Doutores
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('paciente.consultas') }}">
                        <i class="fas fa-calendar-check"></i> Minhas consultas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('paciente.diario') }}">
                        <i class="fas fa-sticky-note"></i> Anotações
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('paciente.historico') }}">
                        <i class="fas fa-history"></i> Histórico
                    </a>
                </li>
            </ul>

            <div class="text-center mb-4 mt-3">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-danger btn-sm">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </nav>

        <!-- Main -->
        <div class="container">
            <div class="content">
                @yield('content')
            </div>
        </div>
    </div>

    <footer class="text-white text-center">
        <div class="container">
            <p class="mb-0">Conecte-se com a gente:</p>
            <a href="https://www.instagram.com/guico_felipe_/?igsh=MXJkZGdoNjl0ankycg%3D%3D" class="text-white mx-2"><i class="fab fa-instagram"></i></a>
            <a href="https://www.instagram.com/thiagonvasque/?igsh=MTBjaW5naXpjMW95MQ%3D%3D" class="text-white mx-2"><i class="fab fa-instagram"></i></a>
            <a href="https://github.com/ThiagoVasque/psychotech" class="text-white mx-2"><i class="fab fa-github"></i></a>
        </div>
        <div class="text-center mt-2">
            <p class="mb-0">© 2024 PsychoTech. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
