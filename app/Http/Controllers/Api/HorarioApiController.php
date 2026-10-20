<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Servico;
use App\Services\AgendaService;
use Carbon\Carbon;
use Illuminate\Http\Request;

 //Informa ao app quais horários de um dia estão livres para um serviço.

class HorarioApiController extends Controller
{
    public function disponibilidade(Request $request, AgendaService $agenda)
    {
        $request->validate([
            'data'                    => 'required|date_format:Y-m-d',
            'servico_id'              => 'required|exists:servicos,id',
            'ignorar_agendamento_id'  => 'nullable|integer',
        ]);

        $ignorar = null;

        // só deixa ignorar um agendamento que seja do próprio cliente (usado ao remarcar)
        // Se o id for de outra cliente, value('id') devolve null e nada é ignorado.
        if ($request->filled('ignorar_agendamento_id')) {
            $ignorar = $request->user()->agendamentos()
                ->whereKey($request->ignorar_agendamento_id)
                ->value('id');
        }
        // Toda a regra de cálculo fica no AgendaService

        $slots = $agenda->slotsDoDia(
            Carbon::parse($request->data),
            Servico::findOrFail($request->servico_id),
            $ignorar
        );

        return response()->json(['data' => $slots]);
    }
}