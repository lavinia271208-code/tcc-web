<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Datas saem como "Y-m-d H:i:s" no horário local (sem "Z"/UTC), para o
 * app Flutter não deslocar o horário do agendamento.
 */
class AgendamentoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // $this->campo acessa o campo do Agendamento que está sendo convertido
        return [
            'id'         => $this->id,
            'data_hora'  => $this->data_hora->format('Y-m-d H:i:s'),
            'servico_id' => $this->servico_id,
            // whenLoaded: só inclui "servico" se o relacionamento já foi carregado
            // (with / load); assim não dispara consulta extra por agendamento.
            'servico'    => $this->whenLoaded('servico', fn () => [
                'id'              => $this->servico->id,
                'nome'            => $this->servico->nome,
                'descricao'       => $this->servico->descricao,
                'preco'           => (float) $this->servico->preco,
                'duracao_minutos' => (int) $this->servico->duracao_minutos,
            ]),
        ];
    }
}