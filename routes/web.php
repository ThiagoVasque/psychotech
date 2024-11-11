<?php

use Laravel\Fortify\Fortify;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\DoutorController;
use App\Http\Controllers\ZoomController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DiarioController;
use App\Http\Controllers\DoutorServicoController; // Certifique-se de importar o controller

// Ignora as rotas padrão do Fortify
Fortify::ignoreRoutes();

// Carrega as rotas do Fortify
require __DIR__.'/fortify.php';

// Rota inicial
Route::get('/', function () {
    return view('home'); 
})->name('home');

// Rotas de Autenticação
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rotas para Pacientes
Route::prefix('paciente')->middleware('auth:paciente')->group(function () {
    Route::get('/', [PacienteController::class, 'home'])->name('paciente.home');
    Route::get('/sessoes', [PacienteController::class, 'sessoes'])->name('paciente.sessoes');
    Route::get('/doutores', [PacienteController::class, 'doutores'])->name('paciente.doutores');
    Route::get('/historico', [PacienteController::class, 'historico'])->name('paciente.historico');
    Route::get('/diario', [DiarioController::class, 'index'])->name('paciente.diario');
    Route::post('/diario', [DiarioController::class, 'store'])->name('paciente.storeDiario');
    Route::put('/diario/{id}', [DiarioController::class, 'update'])->name('paciente.updateDiario');
    Route::delete('/diario/{id}', [DiarioController::class, 'destroy'])->name('paciente.deleteDiario');
});

// Rotas para Doutores
Route::prefix('doutor')->middleware('auth:doutor')->group(function () {
    Route::get('/', [DoutorController::class, 'home'])->name('doutor.home');
    Route::get('/pacientes', [DoutorController::class, 'pacientes'])->name('doutor.pacientes');
    Route::get('/sessoes', [DoutorServicoController::class, 'index'])->name('doutor.sessoes');
    Route::get('/relatorios', [DoutorController::class, 'relatorios'])->name('doutor.relatorios');
    Route::get('/videoconferencia', [DoutorController::class, 'videoconferencia'])->name('doutor.videoconferencia');
    Route::get('/servicos/create', [DoutorServicoController::class, 'create'])->name('doutor.servicos.create');
    Route::post('/servicos', [DoutorServicoController::class, 'store'])->name('doutor.servicos.store');
    Route::get('/servicos/{servico}/edit', [DoutorServicoController::class, 'edit'])->name('doutor.servicos.edit');
    Route::put('/servicos/{servico}', [DoutorServicoController::class, 'update'])->name('doutor.servicos.update');
    Route::delete('/servicos/{servico}', [DoutorServicoController::class, 'destroy'])->name('doutor.servicos.destroy');
    Route::post('/doutor/servicos/{servico}/addHorario', [DoutorController::class, 'addHorario'])->name('doutor.servicos.addHorario');

});

// Rotas para o Zoom
Route::get('/zoom/create-meeting-form', function () {
    return view('zoom.create-meeting-form');
})->middleware('auth'); 
Route::post('/zoom/create-meeting', [ZoomController::class, 'createMeeting'])->middleware('auth'); 
