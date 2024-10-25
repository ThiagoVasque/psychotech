<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\DoutorController;
use App\Http\Controllers\ZoomController;
use App\Http\Controllers\RegisterController;

Route::get('/', function () {
    return view('home');
})->name('home');

// Rotas de Login e Cadastro
Route::get('/login', function () {
    return view('auth.login'); // A view de login
})->name('login');

// Rota de Registro
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');


Route::post('/register', [RegisterController::class, 'register']);

// Rotas para o paciente
Route::get('/paciente/sessoes', [PacienteController::class, 'sessoes'])->name('paciente.sessoes');
Route::get('/paciente/anotacoes', [PacienteController::class, 'anotacoes'])->name('paciente.anotacoes');
Route::get('/paciente/pagamentos', [PacienteController::class, 'pagamentos'])->name('paciente.pagamentos');
Route::get('/paciente/historico', [PacienteController::class, 'historico'])->name('paciente.historico');

// Rotas para o doutor
Route::get('/doutor/pacientes', [DoutorController::class, 'index'])->name('doutor.pacientes');
Route::get('/doutor/sessoes', [DoutorController::class, 'sessoes'])->name('doutor.sessoes');
Route::get('/doutor/relatorios', [DoutorController::class, 'relatorios'])->name('doutor.relatorios');
Route::get('/doutor/videoconferencia', [DoutorController::class, 'videoconferencia'])->name('doutor.videoconferencia');

// Rotas para o Zoom
Route::get('/zoom/create-meeting-form', function () {
    return view('zoom.create-meeting-form');
});

Route::post('/zoom/create-meeting', [ZoomController::class, 'createMeeting']);
