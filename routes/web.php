<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\DoutorController;
use App\Http\Controllers\ZoomController;


//Rota para o home/tela inicial
Route::get('/', function(){
    return view('home');
});

//Rotas para o paciente
Route::get('/paciente/sessoes', [PacienteController::class, 'sessoes'])->name('paciente.sessoes');
Route::get('/paciente/anotacoes', [PacienteController::class, 'anotacoes'])->name('paciente.anotacoes');
Route::get('/paciente/pagamentos', [PacienteController::class, 'pagamentos'])->name('paciente.pagamentos');
Route::get('/paciente/historico', [PacienteController::class, 'historico'])->name('paciente.historico');

//Rotas para o doutor
Route::get('/doutor', [DoutorController::class, 'login'])->name('doutor.login');
Route::get('/doutor/pacientes', [DoutorController::class, 'index'])->name('doutor.pacientes');
Route::get('/doutor/sessoes', [DoutorController::class, 'sessoes'])->name('doutor.sessoes');
Route::get('/doutor/relatorios', [DoutorController::class, 'relatorios'])->name('doutor.relatorios');
Route::get('/doutor/videoconferencia', [DoutorController::class, 'videoconferencia'])->name('doutor.videoconferencia');

//Rotas para o Zoom
Route::get('/zoom/create-meeting-form', function () {
    return view('zoom.create-meeting-form');
});

Route::post('/zoom/create-meeting', [ZoomController::class, 'createMeeting']);