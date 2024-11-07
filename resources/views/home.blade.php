<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
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
        

        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000" style="width: 70%; margin: auto;">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="image/carosel1.png" class="d-block w-100" alt="imagem 1">
        </div>
        <div class="carousel-item">
            <img src="image/carosel2.png" class="d-block w-100" alt="imagem 2">
        </div>
        <div class="carousel-item">
            <img src="image/carosel3.png" class="d-block w-100" alt="imagem 3">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

    <p>Conecte-se com profissionais de saúde de forma rápida e segura, onde quer que você esteja.</p>

        

       
        
        <h2 class="mt-5 brand-color">Por que escolher a PsychoTech?</h2>
        <div class="row mt-4 mb-5" style="margin">
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

<footer class="text-white text-center py-2 " style="background-color: #821AD1;">
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

<!-- Link para Font Awesome, caso necessário -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


</html>