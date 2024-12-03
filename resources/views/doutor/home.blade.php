@extends('layouts.app_doutor')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-4 display-4">Bem-vindo à Home do Doutor</h1>
    <p class="text-center lead">Painel Administrativo</p>

    <div class="row mt-5">
        <div class="col-md-4">
            <div class="card card-custom text-center mb-4 shadow-sm">
                <div class="card-body">
                    <h2 class="card-title">Minhas consultas</h2>
                    <p class="card-text">Veja suas consultas</p>
                    <a href="{{ route('doutor.consultas') }}" class="btn btn-primary btn-custom">Ver Sessões</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-custom text-center mb-4 shadow-sm">
                <div class="card-body">
                    <h2 class="card-title">Meus serviços</h2>
                    <p class="card-text">Veja seus serviços</p>
                    <a href="{{ route('doutor.servicos')}}" class="btn btn-primary btn-custom">Ver Serviços</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-custom text-center mb-4 shadow-sm">
                <div class="card-body">
                    <h2 class="card-title">Relatórios</h2>
                    <p class="card-text">Verifique seus relatórios</p>
                    <a href="{{ route('doutor.relatorios') }}" class="btn btn-primary btn-custom">Ver relatórios</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    body {
        background-color: #f3f4f6;
        font-family: Arial, sans-serif;
    }

    .container {
        max-width: 900px;
    }

    .display-4 {
        font-weight: 700;
        color: #3b3f5c;
    }

    .lead {
        color: #6c757d;
    }

    .card-custom {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        background-color: #ffffff;
    }

    .card-custom:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
    }

    .card-title {
        font-size: 1.25rem;
        color: #5a67d8;
    }

    .card-text {
        font-size: 1rem;
        color: #4a5568;
    }

    .btn-custom {
        background-color: #821AD1;
        border: none;
        color: #ffffff;
        border-radius: 4px;
        transition: background-color 0.2s ease;
    }

    .btn-custom:hover {
        background-color: #9a46db;
    }
</style>