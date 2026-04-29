<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;

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

// Cadastro
Route::get('/cadastro', [AuthController::class, 'showCadastro'])->name('cadastro');
Route::post('/cadastro', [AuthController::class, 'store'])->name('cadastro.store');

// Login
// mostrar a página
Route::get('/login', [LoginController::class, 'index'])->name('login');

// processar o login
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

// Rotas para as páginas do administrador
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::get('/admin/agendamentos', function () {
    return view('admin.agendamentos');
})->name('admin.agendamentos');

Route::get('/admin/servicos', function () {
    return view('admin.servicos');
})->name('admin.servicos');

//adm agend
Route::get('/admin/agendamentos', function () {
    return view('admin.agendamentos');
})->name('admin.agendamentos');