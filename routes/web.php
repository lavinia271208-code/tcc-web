<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HorarioBloqueadoController;

// Pag inicial
Route::get('/', [AgendamentoController::class, 'create'])->name('home');

Route::post('/agendar', [AgendamentoController::class, 'store'])->name('agendamentos.store');


// cadastro
Route::get('/cadastro', [AuthController::class, 'showCadastro'])->name('cadastro');

Route::post('/cadastro', [AuthController::class, 'store'])->name('cadastro.store');


// Login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// área do admin
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {


// Dashboard
Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

Route::delete('/agendamentos/{id}', [AgendamentoController::class, 'destroy'])->name('admin.lista_agendamentos.destroy');
    
// serviços
Route::get('/servicos', [AdminController::class, 'servicos'])->name('admin.servicos');

Route::post('/servicos', [AdminController::class, 'storeServico'])->name('admin.servicos.store');

Route::get('/servicos/{id}/edit', [AdminController::class, 'editServico'])->name('admin.servicos.edit');

Route::put('/servicos/{id}', [AdminController::class, 'updateServico'])->name('admin.servicos.update');

Route::delete('/servicos/{id}', [AdminController::class, 'destroyServico'])->name('admin.servicos.destroy');


// Agendamenos
    
// Lista
Route::get('/lista-agendamentos', [AdminController::class, 'listaAgendamentos'])->name('admin.lista_agendamentos');

// Criar
Route::get('/agendamentos/create', [AgendamentoController::class, 'createAgendamento'])->name('admin.lista_agendamentos.create');

// Salvar
Route::post('/agendamentos', [AgendamentoController::class, 'storeAdmin'])->name('admin.lista_agendamentos.store');

// Editar
Route::put('/agendamentos/{id}', [AgendamentoController::class, 'update'])->name('admin.lista_agendamentos.update');

// full calendar    
Route::get('/admin/agendamentos/events', [AgendamentoController::class, 'getEvents'])->name('admin.agendamentos.events');

// bloqueio de horários
Route::get('/bloqueios', [HorarioBloqueadoController::class, 'index'])->name('admin.bloqueios.index');

Route::post('/bloqueios', [HorarioBloqueadoController::class, 'store'])->name('admin.bloqueios.store');

Route::delete('/bloqueios/{id}', [HorarioBloqueadoController::class, 'destroy'])->name('admin.bloqueios.destroy');

Route::put('/bloqueios/{id}', [HorarioBloqueadoController::class, 'update'])->name('admin.bloqueios.update');
});