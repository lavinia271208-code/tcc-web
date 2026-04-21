<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

Route::get('/', [AgendamentoController::class, 'create']);

Route::post('/agendar', [AgendamentoController::class, 'store'])->name('agendamentos.store');

Route::middleware(['auth', 'admin'])->get('/admin', function () {
    return "Você é admin!";
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/servicos', [AdminController::class, 'servicos'])->name('admin.servicos');
    Route::post('/servicos', [AdminController::class, 'storeServico'])->name('admin.servicos.store');

    Route::get('/agendamentos', [AdminController::class, 'agendamentos'])->name('admin.agendamentos');

});
// Rota para mostrar o formulário de cadastro
Route::get('/cadastro', [AuthController::class, 'showCadastro'])->name('cadastro');

// Rota para processar o cadastro
Route::post('/cadastro', [AuthController::class, 'store'])->name('cadastro.store');

// Rota para login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');