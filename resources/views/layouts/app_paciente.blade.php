<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Paciente</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="d-flex">
        <!-- Navbar Lateral Paciente -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light flex-column" style="width: 250px; height: 100vh; position: fixed; overflow-y: auto; box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);">
            <!-- Exibindo o Nome do Usuário Logado -->
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
                <!-- Opções do Paciente -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('paciente.home') }}">
                        <i class="fas fa-home"></i> Início
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('paciente.sessoes') }}">
                        <i class="fas fa-calendar-check"></i> Gerenciar Sessões
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('paciente.pagamentos') }}">
                        <i class="fas fa-wallet"></i> Pagamentos
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

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

<footer class="text-white text-center py-2 fixed-bottom" style="background-color: #821AD1;">
  <div class="container">
    <p class="mb-0">Conecte-se com a gente:</p>
    <a href="#" class="text-white mx-2"><i class="fab fa-facebook-f"></i></a>
    <a href="#" class="text-white mx-2"><i class="fab fa-twitter"></i></a>
    <a href="#" class="text-white mx-2"><i class="fab fa-instagram"></i></a>
  </div>
  <div class="text-center mt-2">
    <p class="mb-0">© 2024 PsychoTech. Todos os direitos reservados.</p>
  </div>
</footer>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</html>
