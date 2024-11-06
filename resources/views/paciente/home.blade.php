@extends('layouts.app_paciente')

@section('content')
<div >
    
    <h1 class="text-center mt-4">Bem-vindo à Home do Paciente</h1>
    <p class="text-center">Aqui você pode gerenciar suas sessões, pagamentos e anotações.</p>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-center mb-4 shadow-sm">
                <div class="card-body">
                    <h2 class="card-title">Gerenciar Sessões</h2>
                    <p class="card-text">Visualize e agende suas próximas sessões com os profissionais de saúde.</p>
                    <a href="{{ route('paciente.sessoes') }}" class="btn btn-primary">Ver Sessões</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center mb-4 shadow-sm">
                <div class="card-body">
                    <h2 class="card-title">Pagamentos</h2>
                    <p class="card-text">Consulte seus pagamentos e faturas.</p>
                    <a href="{{ route('paciente.pagamentos') }}" class="btn btn-primary">Ver Pagamentos</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center mb-4 shadow-sm">
                <div class="card-body">
                    <h2 class="card-title">Anotações</h2>
                    <p class="card-text">Mantenha suas anotações e lembretes em dia.</p>
                    <a href="{{ route('paciente.diario') }}" class="btn btn-primary">Ver Anotações</a>
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection
