<?php

use Laravel\Fortify\Fortify;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\DoutorController;
use App\Http\Controllers\ZoomController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DiarioController;
use App\Http\Controllers\DoutorServicoController;
use App\Http\Controllers\PacienteServicoController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\DoutorRelatorioController;

// Ignora as rotas padrão do Fortify
Fortify::ignoreRoutes();

// Carrega as rotas do Fortify
require __DIR__ . '/fortify.php';

// Rota inicial
Route::get('/', function () {
    return view('home');
})->name('home');

// Rotas de redefinição de senha
Route::prefix('password')->name('password.')->group(function () {
    Route::get('forgot', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('request');
    Route::post('forgot', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('email');
    Route::get('password/reset/{token}', function ($token) {
        return view('auth.password-reset', ['token' => $token]);
    })->name('password.reset');
    Route::post('reset', [ForgotPasswordController::class, 'reset'])->name('update');
});

// Rotas de Autenticação
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rotas para Pacientes
Route::prefix('paciente')->middleware('auth:paciente')->group(function () {
    // Home do Paciente
    Route::get('/', [PacienteController::class, 'home'])->name('paciente.home');

    // Consultas do Paciente
    Route::get('/consultas', [ConsultaController::class, 'index'])->name('paciente.consultas');
    Route::post('/consultas/agendar/{slot}', [PacienteServicoController::class, 'agendar'])->name('paciente.consulta.agendar');

    // Histórico de Consultas
    Route::get('/historico', [PacienteController::class, 'historico'])->name('paciente.historico');

    // Serviços de Doutores
    Route::get('/servicos', [PacienteServicoController::class, 'index'])->name('paciente.servicos');
    Route::post('/servicos/{servico}/agendar/{slotId}', [PacienteServicoController::class, 'agendar'])->name('paciente.servicos.agendar');

    Route::get('/servicos/{servico}/slots', [PacienteServicoController::class, 'exibirSlots'])->name('paciente.servicos_slots');

    // Diário do Paciente
    Route::get('/diario', [DiarioController::class, 'index'])->name('paciente.diario');
    Route::post('/diario', [DiarioController::class, 'store'])->name('paciente.storeDiario');
    Route::put('/diario/{id}', [DiarioController::class, 'update'])->name('paciente.updateDiario');
    Route::delete('/diario/{id}', [DiarioController::class, 'destroy'])->name('paciente.deleteDiario');
});

// Rotas para Doutores
Route::prefix('doutor')->middleware('auth:doutor')->group(function () {
    Route::get('/', [DoutorController::class, 'home'])->name('doutor.home');

    // Consultas do Doutor
    Route::get('/consultas', [DoutorController::class, 'consultas'])->name('doutor.consultas');

    // Relatórios do Doutor
    Route::get('/relatorios', [DoutorRelatorioController::class, 'index'])->name('doutor.relatorios');

    // Serviços do Doutor
    Route::get('/servicos', [DoutorServicoController::class, 'index'])->name('doutor.servicos');
    Route::get('/servicos/create', [DoutorServicoController::class, 'create'])->name('doutor.servicos.create');
    Route::post('/servicos', [DoutorServicoController::class, 'store'])->name('doutor.servicos.store');
    Route::put('/servicos/{servico}', [DoutorServicoController::class, 'update'])->name('doutor.servicos.update');
    Route::delete('/servicos/{servico}', [DoutorServicoController::class, 'destroy'])->name('doutor.servicos.destroy');
});
