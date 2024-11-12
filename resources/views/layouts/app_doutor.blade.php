<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Doutor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="d-flex">
        <!-- Navbar Lateral Doutor -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light flex-column" style="width: 250px; height: 100vh; position: fixed; overflow-y: auto; box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);">
            <!-- Exibindo o Nome do Usuário Logado -->
            <div class="text-center mb-4 mt-3">
                <h5>Olá Dr(a)</h5>
                @if(auth()->check())
                    <h3>{{ auth()->user()->nome }}</h3>
                    <small class="text-muted">{{ ucfirst(auth()->user()->role) }}</small>
                @else
                    <h3>Usuário não autenticado</h3>
                @endif
            </div>

            <ul class="navbar-nav flex-column">
                <!-- Opções do Doutor -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('doutor.home') }}">
                        <i class="fas fa-home"></i> Início
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('doutor.pacientes') }}">
                        <i class="fas fa-user"></i> Meus Pacientes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('doutor.sessoes') }}">
                        <i class="fas fa-calendar-check"></i> Meus Serviços
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('doutor.relatorios') }}">
                        <i class="fas fa-file-alt"></i>   Relatórios
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('doutor.videoconferencia') }}">
                        <i class="fas fa-video"></i> Consultas
                    </a>
                </li>
            </ul>
            
            <div class="text-center mb-4 mt-3">
                <!-- Botão de Logout -->
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-danger btn-sm">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </nav>

        <!-- Conteúdo Principal -->
        <div class="container" style="margin-left: 250px; padding-top: 20px;">
            <div class="content">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script> 
</body>

<footer class="text-white text-center py-2 fixed-bottom" style="background-color: #821AD1;">
  <div class="container">
    <p class="mb-0">Conecte-se com a gente:</p>
    <a href="https://www.instagram.com/guico_felipe_/?igsh=MXJkZGdoNjl0ankycg%3D%3D" class="text-white mx-2"><i class="fab fa-instagram"></i></a>
    <a href="https://www.instagram.com/thiagonvasque/?igsh=MTBjaW5naXpjMW95MQ%3D%3D" class="text-white mx-2"><i class="fab fa-instagram"></i></a>
    <a href="https://github.com/ThiagoVasque/psychotech" class="text-white mx-2"><i class="fab fa-github"></i></a> <!-- Ícone do GitHub -->
  </div>
  <div class="text-center mt-2">
    <p class="mb-0">© 2024 PsychoTech. Todos os direitos reservados.</p>
  </div>
</footer>


</html>
