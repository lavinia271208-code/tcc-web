<?php

namespace Database\Seeders;

use App\Models\HorarioBloqueado;
use Illuminate\Database\Seeder;

class HorariosBloqueadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        HorarioBloqueado::create([
            'user_id' => 1,
            'data_hora_inicio' => '2026-08-10 12:00:00',
            'data_hora_fim' => '2026-08-10 13:00:00',
            'motivo' => 'Horário de almoço',
        ]);

        HorarioBloqueado::create([
            'user_id' => 1,
            'data_hora_inicio' => '2026-08-15 08:00:00',
            'data_hora_fim' => '2026-08-15 10:00:00',
            'motivo' => 'Curso de aperfeiçoamento',
        ]);

        HorarioBloqueado::create([
            'user_id' => 1,
            'data_hora_inicio' => '2026-08-20 14:00:00',
            'data_hora_fim' => '2026-08-20 18:00:00',
            'motivo' => 'Compromisso particular',
        ]);
    }
}
