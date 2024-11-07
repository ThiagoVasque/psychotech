<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #821AD1;">
    <div class="container-fluid">
        <a class="navbar-brand text-white" href="{{ route('home') }}">Psychotech</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Doutores</a> <!-- Link para Doutores -->
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Planos</a> <!-- Link para Planos -->
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('register') }}">Cadastrar</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    /* Ajusta a cor do ícone da navbar-toggler para branco */
    .navbar-toggler-icon {
        filter: invert(1);
    }
</style>
