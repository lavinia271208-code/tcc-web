<?php

use App\Http\Controllers\Api\AgendamentoApiController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\HorarioApiController;
use App\Http\Controllers\Api\ServicoApiController;
use Illuminate\Support\Facades\Route;

// Rotas públicas
Route::post('/login', [AuthApiController::class, 'login']);
Route::post('/cadastro', [AuthApiController::class, 'cadastro']);

// Rotas protegidas (exigem token Sanctum válido)
Route::middleware('auth:sanctum')->group(function () {

    // dados do usuário logado e encerramento da sessão (revoga o token atual)
    Route::get('/user', [AuthApiController::class, 'user']);
    Route::post('/logout', [AuthApiController::class, 'logout']);

    // lista de serviços
    Route::get('/servicos', [ServicoApiController::class, 'index']);

    // horários disponíveis 
    Route::get('/horarios-disponiveis', [HorarioApiController::class, 'disponibilidade']);

    // agendamentos do cliente logado
    Route::get('/meus-agendamentos', [AgendamentoApiController::class, 'index']);
    Route::post('/agendamentos', [AgendamentoApiController::class, 'store']);
    Route::put('/agendamentos/{id}', [AgendamentoApiController::class, 'update']);
    Route::delete('/agendamentos/{id}', [AgendamentoApiController::class, 'destroy']);
});