<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AgendamentoResource;
use App\Models\Agendamento;
use App\Models\Servico;
use App\Services\AgendaService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgendamentoApiController extends Controller
{
    private const MSG_INDISPONIVEL = 'O horário selecionado está indisponível.';

    // GET /api/meus-agendamentos  (mais próximos primeiro; passados no fim)
    public function index(Request $request)
    {
        $agendamentos = Agendamento::with('servico')
            ->where('user_id', $request->user()->id)
            ->orderByRaw('data_hora < ? asc', [Carbon::now()])
            ->orderBy('data_hora')
            ->get();
        // Resource padroniza o JSON de saída (ver AgendamentoResource)
        return AgendamentoResource::collection($agendamentos);
    }

    // POST /api/agendamentos
    public function store(Request $request, AgendaService $agenda)
    {
        $request->validate([
            'servico_id' => 'required|exists:servicos,id',
            'data_hora'  => 'required|date_format:Y-m-d H:i:s',
        ]);

        $servico = Servico::findOrFail($request->servico_id);
        $inicio  = Carbon::parse($request->data_hora);

        // transação + trava: evita duas clientes pegarem o mesmo horário ao mesmo tempo
        $agendamento = DB::transaction(function () use ($request, $agenda, $servico, $inicio) {
            Agendamento::whereDate('data_hora', $inicio)->lockForUpdate()->get();

            // Mesmas regras da tela de horários disponíveis (expediente, almoço, bloqueios...)
            if (! $agenda->horarioLivre($inicio, $servico)) {
                return null;
            }

            return Agendamento::create([
                'user_id'    => $request->user()->id,
                'servico_id' => $servico->id,
                'data_hora'  => $inicio,
            ]);
        });

        if (! $agendamento) {
            // 422 = dados válidos no formato, mas não processáveis (horário indisponível)
            return response()->json(['message' => self::MSG_INDISPONIVEL], 422);
        }

        return (new AgendamentoResource($agendamento->load('servico')))
            ->response()->setStatusCode(201);
    }

    // PUT /api/agendamentos/{id}  (remarcar: novo dia/hora e, opcionalmente, novo serviço)
    public function update(Request $request, $id, AgendaService $agenda)
    {
        $request->validate([
            'servico_id' => 'sometimes|exists:servicos,id',
            'data_hora'  => 'required|date_format:Y-m-d H:i:s',
        ]);

        // Filtrar por user_id antes do findOrFail: agendamento de outra cliente dá 404

        $agendamento = Agendamento::where('user_id', $request->user()->id)->findOrFail($id);
        // Se não veio servico_id, mantém o serviço atual
        $servico     = Servico::findOrFail($request->input('servico_id', $agendamento->servico_id));
        $inicio      = Carbon::parse($request->data_hora);

        $ok = DB::transaction(function () use ($agenda, $agendamento, $servico, $inicio) {
            Agendamento::whereDate('data_hora', $inicio)->lockForUpdate()->get();
            // Passa o id do próprio agendamento para ele não bloquear o próprio horário

            if (! $agenda->horarioLivre($inicio, $servico, $agendamento->id)) {
                return false;
            }

            $agendamento->update([
                'servico_id' => $servico->id,
                'data_hora'  => $inicio,
            ]);

            return true;
        });

        if (! $ok) {
            return response()->json(['message' => self::MSG_INDISPONIVEL], 422);
        }
        // fresh() recarrega do banco com o serviço atualizado
        return new AgendamentoResource($agendamento->fresh('servico'));
    }

    // DELETE /api/agendamentos/{id}  (cliente cancela o próprio agendamento)
    public function destroy(Request $request, $id)
    {
        // Soft delete: o registro some das consultas, mas continua no banco

        Agendamento::where('user_id', $request->user()->id)->findOrFail($id)->delete();

        return response()->json(['message' => 'Agendamento cancelado com sucesso.']);
    }
}