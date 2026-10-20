<?php

namespace App\Services;

use App\Models\Agendamento;
use App\Models\HorarioBloqueado;
use App\Models\Servico;
use Carbon\Carbon;

/**
 * Regras de agenda compartilhadas entre "horários disponíveis" e "criar/remarcar
 * agendamento", para que as duas rotas nunca discordem uma da outra.
 */
class AgendaService
{
    /**
     * Gera os slots do dia para o serviço: [['hora' => '08:00', 'ativo' => true], ...]
     * $ignorarAgendamentoId permite remarcar sem que o próprio agendamento bloqueie o slot.
     */
    public function slotsDoDia(Carbon $dia, Servico $servico, ?int $ignorarAgendamentoId = null): array
    {
        $dia     = $dia->copy()->startOfDay();
        $duracao = (int) $servico->duracao_minutos;

        if ($duracao <= 0 || ! in_array($dia->dayOfWeek, config('agenda.dias_funcionamento'))) {
            return [];
        }

        $data       = $dia->format('Y-m-d');
        $abertura   = Carbon::parse("$data " . config('agenda.abertura'));
        $fechamento = Carbon::parse("$data " . config('agenda.fechamento'));

        $intervaloInicio = config('agenda.intervalo_inicio') ? Carbon::parse("$data " . config('agenda.intervalo_inicio')) : null;
        $intervaloFim    = config('agenda.intervalo_fim') ? Carbon::parse("$data " . config('agenda.intervalo_fim')) : null;

        $fimDoDia = $dia->copy()->endOfDay();

        // qualquer bloqueio que encoste no dia (inclusive os que atravessam vários dias)
        $bloqueios = HorarioBloqueado::where('data_hora_inicio', '<', $fimDoDia)
            ->where('data_hora_fim', '>', $dia)
            ->get();

        $agendamentos = Agendamento::with('servico')
            ->when($ignorarAgendamentoId, fn ($q) => $q->where('id', '!=', $ignorarAgendamentoId))
            ->whereBetween('data_hora', [$dia->copy()->subDay(), $fimDoDia])
            ->get();

        $slots  = [];
        $cursor = $abertura->copy();
        $agora  = Carbon::now();

        while ($cursor->copy()->addMinutes($duracao)->lte($fechamento)) {
            $inicio = $cursor->copy();
            $fim    = $cursor->copy()->addMinutes($duracao);

            // não oferece slot que invada o intervalo de almoço
            if ($intervaloInicio && $intervaloFim && $inicio->lt($intervaloFim) && $fim->gt($intervaloInicio)) {
                $cursor = $intervaloFim->copy();
                continue;
            }

            // não oferece horário que já passou
            if ($inicio->lt($agora)) {
                $cursor->addMinutes($duracao);
                continue;
            }

            $bloqueado = $bloqueios->contains(
                fn ($b) => $b->data_hora_inicio < $fim && $b->data_hora_fim > $inicio
            );

            $ocupado = $agendamentos->contains(function ($a) use ($inicio, $fim) {
                $aFim = $a->data_hora->copy()->addMinutes((int) optional($a->servico)->duracao_minutos);
                return $a->data_hora < $fim && $aFim > $inicio;
            });

            $slots[] = [
                'hora'  => $inicio->format('H:i'),
                'ativo' => ! $bloqueado && ! $ocupado,
            ];

            $cursor->addMinutes($duracao);
        }

        return $slots;
    }

    /** O horário pedido é um slot existente e livre? */
    public function horarioLivre(Carbon $inicio, Servico $servico, ?int $ignorarAgendamentoId = null): bool
    {
        $hora = $inicio->format('H:i');

        foreach ($this->slotsDoDia($inicio, $servico, $ignorarAgendamentoId) as $slot) {
            if ($slot['hora'] === $hora) {
                return $slot['ativo'];
            }
        }

        return false;
    }
}