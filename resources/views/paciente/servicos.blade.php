@extends('layouts.app_paciente')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">Lista de Doutores</h1>
    <div class="row">
        @foreach ($doutores as $doutor)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-light rounded">
                    <div class="text-center mt-3">
                        <!-- Foto do doutor -->
                        <img src="https://via.placeholder.com/150?text=Médico" class="img-fluid rounded-circle"
                            alt="Imagem do Médico" style="width: 100px; height: 100px;">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-center">{{ $doutor->nome }}</h5>
                        <p class="card-text text-center"><strong>Especialidade:</strong> {{ $doutor->especialidade }}</p>


                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <h6>Serviços:</h6>
                            <a href="#" class="btn btn-outline-info btn-sm">Ver mais</a>
                        </div>

                        <ul class="list-unstyled mt-3">
                            @foreach ($doutor->servicos as $servico)
                                <li class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $servico->titulo }}</strong><br>
                                            {{ $servico->descricao }}
                                        </div>
                                        <div>
                                            <span class="badge bg-info">R$
                                                {{ number_format($servico->preco, 2, ',', '.') }}</span>
                                        </div>
                                    </div>
                                    <form action="{{ route('paciente.servicos.agendar', $servico->id) }}" method="POST"
                                        class="mt-2">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm w-100">Agendar Consulta</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection