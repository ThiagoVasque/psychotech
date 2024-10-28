<?php

use Laravel\Fortify\Fortify;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\DoutorController;
use App\Http\Controllers\ZoomController;
use App\Http\Controllers\Auth\RegisterController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;

// Ignora as rotas padrão do Fortify
Fortify::ignoreRoutes();

// Carrega as rotas do Fortify
require __DIR__.'/fortify.php';

// Rota inicial
Route::get('/', function () {
    return view('home'); // A página inicial
})->name('home');

// Rota de Login
Fortify::loginView(function () {
    return view('auth.login');
});

// Rota de Registro
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Autenticação
Route::post('login', [AuthController::class, 'login'])->name('login'); 

// Rota de Logout
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Rotas para doutores e pacientes
Route::middleware(['auth:doutor'])->group(function () {
    Route::get('/doutor', [DoutorController::class, 'home'])->name('doutor.home');
});

Route::middleware(['auth:paciente'])->group(function () {
    Route::get('/paciente', [PacienteController::class, 'home'])->name('paciente.home');
});

// Rotas protegidas
Route::middleware(['auth'])->group(function () {
    Route::prefix('paciente')->group(function () {
        Route::get('/sessoes', [PacienteController::class, 'sessoes'])->name('paciente.sessoes');
        Route::get('/anotacoes', [PacienteController::class, 'anotacoes'])->name('paciente.anotacoes');
        Route::get('/pagamentos', [PacienteController::class, 'pagamentos'])->name('paciente.pagamentos');
        Route::get('/historico', [PacienteController::class, 'historico'])->name('paciente.historico');
    });

    Route::prefix('doutor')->group(function () {
        Route::get('/pacientes', [DoutorController::class, 'index'])->name('doutor.pacientes');
        Route::get('/sessoes', [DoutorController::class, 'sessoes'])->name('doutor.sessoes');
        Route::get('/relatorios', [DoutorController::class, 'relatorios'])->name('doutor.relatorios');
        Route::get('/videoconferencia', [DoutorController::class, 'videoconferencia'])->name('doutor.videoconferencia');
    });
});

// Rotas para o Zoom
Route::get('/zoom/create-meeting-form', function () {
    return view('zoom.create-meeting-form');
})->middleware('auth'); // Adicione a autenticação, se necessário

Route::post('/zoom/create-meeting', [ZoomController::class, 'createMeeting'])->middleware('auth'); // Adicione a autenticação, se necessário
