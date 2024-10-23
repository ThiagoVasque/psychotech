<!-- resources/views/home.blade.php -->
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
        footer {
            margin-top: 50px;
            padding: 20px 0;
            background-color: #6f42c1;
            color: #fff;
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
                        <a href="{{ route('login') }}" class="btn btn-custom">Entrar</a>
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

        <h2 class="mt-5 brand-color">Perguntas Frequentes</h2>
        <div class="accordion mt-4" id="faqAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="faqOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        O que é telemedicina?
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="faqOne" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        A telemedicina é a prestação de serviços médicos à distância, utilizando tecnologias de informação e comunicação.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="faqTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Quais são os benefícios da telemedicina?
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="faqTwo" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Os principais benefícios incluem acesso rápido a médicos, conforto, redução de custos e tempo, além de um ambiente seguro para atendimento.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="faqThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Como funciona o agendamento?
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="faqThree" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Você pode agendar uma consulta diretamente em nosso site, escolhendo o médico e o horário que mais lhe convém.
                    </div>
                </div>
            </div>
        </div>

        <footer class="text-center">
            <p>&copy; {{ date('Y') }} PsychoTech. Todos os direitos reservados.</p>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
