<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Psychotech - Telemedicina de Ponta</title>

    <!-- Importando fontes do Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Open+Sans:wght@300;400;600&display=swap"
        rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* Estilo global */
        body {
            background-color: #f8f9fa;
            font-family: 'Roboto', sans-serif;
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

        /* Estilo para os cards */
        .card-custom {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 30px;
            overflow: hidden;
        }

        .card-custom:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .card-custom .extra-info {
            display: none;
            font-size: 0.9rem;
            color: #555;
            margin-top: 0.5rem;
        }

        .card-custom:hover .extra-info {
            display: block;
        }

        /* Estilo para os títulos */
        h2.brand-color,
        h1.brand-color {
            font-family: 'Open Sans', sans-serif;
            font-weight: 700;
            color: #6f42c1;
        }

        /* Estilo para o botão */
        .btn-custom {
            font-size: 16px;
            padding: 12px 30px;
            border-radius: 30px;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #5a379f;
        }

        footer {
            background-color: #821AD1;
            color: white;
            padding: 10px 0;
            /* Reduzindo o padding vertical */
            font-size: 0.9rem;
            /* Diminui o tamanho da fonte */
            text-align: center;
        }

        footer a {
            color: white;
            margin: 0 10px;
        }

        footer p {
            color: white;
            margin: 0;
            /* Remove a margem para deixar o texto mais compacto */
        }

        footer .container {
            padding: 0;
            /* Remove o padding extra da container */
        }





        /* Carousel */
        #carouselExampleIndicators {
            max-width: 100%;
            margin-bottom: 30px;
        }

        .carousel-item img {
            object-fit: cover;
        }

        .carousel-img {
            height: 400px;
            object-fit: cover;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .carousel-item img {
                height: 300px;
            }

            .col-md-9,
            .col-md-3 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .container {
                padding: 0 15px;
            }
        }

        /* Estilo do texto */
        p {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #333;
        }
    </style>
</head>

<body>

    <x-navbar />
    <div class="container-fluid text-center mt-4 mb-5">
        <h1 class="brand-color mb-4">Bem-vindo à PsychoTech - Sua Plataforma de Telemedicina</h1>


        <!-- Carousel -->
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
              
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="image/carousel1.png" class="d-block w-100 carousel-img" alt="imagem 1">
                </div>
                <div class="carousel-item">
                    <img src="image/carousel2.png" class="d-block w-100 carousel-img" alt="imagem 2">
                </div>
        
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <!-- Parágrafo centralizado -->
    <p class="text-center mt-2">Conecte-se com profissionais de saúde de forma rápida e segura, onde quer que você
        esteja.</p>


    <div class="container-sm mt-5">
        <h2 style="text-align:center;" class="brand-color">Sobre a PsychoTech</h2>

        <div class="row">
            <div class="col-md-9">
                <p style="text-align: justify;">
                    A PsychoTech nasceu com o propósito de transformar a forma como as pessoas acessam cuidados médicos,
                    promovendo inovações constantes e um atendimento centrado no bem-estar do paciente. A PsychoTech vem se destacando como referência em conectar pacientes a
                    profissionais de saúde de maneira rápida, segura e eficiente.
                </p>
                <p style="text-align: justify;">
                    Desde sua fundação, a PsychoTech investe em tecnologia de ponta, permitindo que seus usuários tenham
                    acesso a diagnósticos de alta precisão e consultas médicas no conforto de suas casas. O compromisso
                    com a inovação é uma marca registrada da plataforma, que se mantém à frente no setor ao proporcionar
                    soluções que valorizam o tempo, a saúde e a privacidade de seus pacientes.
                </p>
                <p style="text-align: justify;">
                    A PsychoTech oferece um serviço integrado de telemedicina na região, garantindo que
                    a população local e de outros estados pudesse se beneficiar das facilidades de um atendimento remoto
                    de qualidade.
                </p>
            </div>

            <div class="col-md-3 mt-2">
                <img src="image/logo.jpeg" class="img-fluid rounded" alt="Imagem da PsychoTech">
            </div>
        </div>

        <p class="full-width-text">
            Hoje, com uma equipe especializada e ferramentas avançadas, a plataforma continua sua missão de democratizar
            a saúde e levar acessibilidade e eficiência a quem precisa. Assim, a PsychoTech reafirma seu papel como uma
            aliada indispensável na jornada de cuidado com a saúde, promovendo conforto, segurança e tecnologia a todos
            os seus usuários.
        </p>
    </div>


    <h2 style="text-align:center;" class="mt-5 brand-color">Por que escolher a PsychoTech?</h2>

    <div style="text-align: justify;" class="container">
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card card-custom">
                    <div class="card-body">
                        <h5 style="text-align:center;" class="card-title">Acesso Rápido</h5>
                        <p class="card-text">Na PsychoTech, agendar consultas médicas é fácil, rápido e sem a
                            necessidade de sair de casa. Com nossa plataforma de telemedicina, você se conecta
                            com profissionais de saúde em minutos, evitando filas e deslocamentos. Tudo isso de
                            forma ágil e com total proteção aos seus dados.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom">
                    <div class="card-body">
                        <h5 style="text-align:center;" class="card-title">Conforto</h5>
                        <p class="card-text">Conectamos você a profissionais de saúde com
                            rapidez e facilidade, permitindo que suas consultas aconteçam onde você se sentir
                            mais à vontade. Nossa plataforma oferece uma solução prática e segura para quem
                            busca comodidade no atendimento médico.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom">
                    <div class="card-body">
                        <h5 style="text-align:center;" class="card-title">Segurança</h5>
                        <p class="card-text">Valorizamos a sua privacidade e nos comprometemos em proteger seus
                            dados pessoais, garantindo que todas as suas informações estejam seguras em nosso
                            sistema. Estamos aqui para proporcionar a você uma experiência tranquila e segura,
                            priorizando a integridade dos seus dados em cada interação.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <p class=>Conecte-se com a gente:</p>
            <a href="https://github.com/ThiagoVasque/psychotech"><i class="fab fa-github"></i></a>
        </div>
        <div class="text-center mt-2">
            <p class="mb-0">© 2024 PsychoTech. Todos os direitos reservados.</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>