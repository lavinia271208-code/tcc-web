<?php

return [
    // horário de abertura e fechamento (formato H:i)
    'abertura'   => env('AGENDA_ABERTURA', '08:00'),
    'fechamento' => env('AGENDA_FECHAMENTO', '18:00'),

    // intervalo de almoço (deixe null em ambas as chaves se não houver)
    'intervalo_inicio' => env('AGENDA_INTERVALO_INICIO', '12:00'),
    'intervalo_fim'    => env('AGENDA_INTERVALO_FIM', '13:00'),

    // dias da semana em que o estabelecimento funciona
    // 0 = domingo, 1 = segunda, ..., 6 = sábado
    'dias_funcionamento' => [1, 2, 3, 4, 5, 6],
];