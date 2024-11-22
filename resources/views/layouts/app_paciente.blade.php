<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Paciente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>

<body>
    <div class="d-flex" style="min-height: 100vh;">
        <!-- Sidebar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light flex-column"
            style="width: 250px; height: 100%; position: fixed; top: 0; left: 0; bottom: 0; overflow-y: auto; box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);">

            <div class="text-center mb-4 mt-3">
                <h5>Olá</h5>
                @auth
                    <div class="mb-2">
                        <!-- Foto de Perfil -->
                        <img src="{{ asset('storage/' . auth()->user()->foto_perfil) }}" alt="Foto de Perfil"
                            class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                    </div>
                    <h3>{{ auth()->user()->nome }}</h3>
                    <small class="text-muted">{{ ucfirst(auth()->user()->role) }}</small>
                @else
                    <h3>Usuário não autenticado</h3>
                @endauth
            </div>

            <ul class="navbar-nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('paciente.home') }}">
                        <i class="fas fa-home"></i> Início
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('paciente.servicos') }}">
                        <i class="fas fa-user"></i> Doutores
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('paciente.consultas') }}">
                        <i class="fas fa-user"></i> Minhas consultas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('paciente.diario') }}">
                        <i class="fas fa-calendar-check"></i> Meu diário
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('paciente.historico') }}">
                        <i class="fas fa-file-alt"></i> Relatórios
                    </a>
                </li>
            </ul>

            <!-- Botões de Gerenciamento e Logout abaixo do sidebar -->
            <div class="mt-auto text-center mb-4">
                <!-- Botão de Configurações (Engrenagem) -->
                <a href="" class="btn btn-primary btn-sm mb-2 w-100">
                    <i class="fas fa-cogs"></i> Gerenciar Perfil
                </a>

                <!-- Botão de Logout -->
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="btn btn-danger btn-sm w-100">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="container" style="margin-left: 250px; padding-top: 20px; padding-bottom: 80px;">
            <div class="content">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    @stack('scripts')
    <script src="{{ asset('js/app.js') }}"></script>

</body>

</html>