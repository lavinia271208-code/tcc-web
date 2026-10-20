<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Servico;

class ServicoApiController extends Controller
{
    // GET /api/servicos
    public function index()
    {
        // map() monta cada serviço só com os campos necessários; os casts garantem
        // que preco chegue como número (não texto "180.00") e duração como inteiro.
        $servicos = Servico::orderBy('nome')->get()->map(fn ($s) => [
            'id'              => $s->id,
            'nome'            => $s->nome,
            'descricao'       => $s->descricao,
            'preco'           => (float) $s->preco,
            'duracao_minutos' => (int) $s->duracao_minutos,
        ]);

        return response()->json(['data' => $servicos]);
    }
}