<?php


use Laravel\Fortify\Fortify;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\DoutorController;
use App\Http\Controllers\ZoomController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DiarioController;

// Ignora as rotas padrão do Fortify
Fortify::ignoreRoutes();

// Carrega as rotas do Fortify
require __DIR__.'/fortify.php';

// Rota inicial
Route::get('/', function () {
    return view('home'); // A página inicial
})->name('home');


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

// Rota de Logout
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'auth:paciente'], function () {
    Route::get('/paciente', [PacienteController::class, 'home'])->name('paciente.home');
});

Route::group(['middleware' => 'auth:doutor'], function () {
    Route::get('/doutor', [DoutorController::class, 'home'])->name('doutor.home');
});

// Rotas protegidas para pacientes
Route::middleware(['auth'])->group(function () {

    Route::prefix('paciente')->group(function () {
        Route::get('/sessoes', [PacienteController::class, 'sessoes'])->name('paciente.sessoes');
        Route::get('/pagamentos', [PacienteController::class, 'pagamentos'])->name('paciente.pagamentos');
        Route::get('/historico', [PacienteController::class, 'historico'])->name('paciente.historico'); 
        Route::get('/diario', [DiarioController::class, 'index'])->name('paciente.diario');
    Route::post('/diario', [DiarioController::class, 'store'])->name('paciente.storeDiario');
    
    Route::post('/diario/{id}', [DiarioController::class, 'update'])->name('paciente.updateDiario'); // Atualiza uma anotação
    
    Route::post('/diario/{id}/delete', [DiarioController::class, 'destroy'])->name('paciente.deleteDiario');

        
    });
});

// Rotas para doutores
Route::prefix('doutor')->middleware(['auth:doutor'])->group(function () {
    Route::get('/pacientes', [DoutorController::class, 'index'])->name('doutor.pacientes');
    Route::get('/sessoes', [DoutorController::class, 'sessoes'])->name('doutor.sessoes');
    Route::get('/relatorios', [DoutorController::class, 'relatorios'])->name('doutor.relatorios');
    Route::get('/videoconferencia', [DoutorController::class, 'videoconferencia'])->name('doutor.videoconferencia');
});

// Rotas para o Zoom
Route::get('/zoom/create-meeting-form', function () {
    return view('zoom.create-meeting-form');
})->middleware('auth'); // Adicione a autenticação, se necessário

Route::post('/zoom/create-meeting', [ZoomController::class, 'createMeeting'])->middleware('auth'); // Adicione a autenticação, se necessário
