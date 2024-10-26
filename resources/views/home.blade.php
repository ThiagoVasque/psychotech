<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Psychotech - Telemedicina de Ponta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            margin: 0; 
            padding: 0; 
        }
        .brand-color {
            color: #6f42c1;
        }
        .btn-custom {
            background-color: #6f42c1;
            color: #fff;
        }
        .btn-custom:hover {
            background-color: #5a379f;
        }
        .card-custom {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <x-navbar />
    <div class="container text-center mt-5">
        <h1 class="brand-color">Bem-vindo à PsychoTech - Sua Plataforma de Telemedicina</h1>
        <p>Conecte-se com profissionais de saúde de forma rápida e segura, onde quer que você esteja.</p>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card card-custom mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Login</h5>
                        <p class="card-text">Já possui uma conta? Faça login para acessar seus dados e agendar consultas.</p>
                        <a href="{{ route('login') }}" class="btn btn-custom">Entrar</a> <!-- Corrigido para 'login' -->
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-custom mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Cadastrar</h5>
                        <p class="card-text">Se você é um novo usuário, cadastre-se para começar a utilizar nossos serviços.</p>
                        <a href="{{ route('register') }}" class="btn btn-success">Cadastrar</a>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="mt-5 brand-color">Por que escolher a PsychoTech?</h2>
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card card-custom">
                    <div class="card-body">
                        <h5 class="card-title">Acesso Rápido</h5>
                        <p class="card-text">Agende consultas e converse com médicos em questão de minutos, sem sair de casa.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom">
                    <div class="card-body">
                        <h5 class="card-title">Conforto</h5>
                        <p class="card-text">Receba atendimento médico no conforto do seu lar, evitando deslocamentos e filas.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom">
                    <div class="card-body">
                        <h5 class="card-title">Segurança</h5>
                        <p class="card-text">Protegemos seus dados pessoais e garantimos um ambiente seguro para suas consultas.</p>
                    </div>
                </div>
            </div>
        </div>
    </div> 

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
