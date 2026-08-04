<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agendamento;

class AgendamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Agendamento::create([
            'user_id' => 2,
            'servico_id' => 1,
            'data_hora' => '2026-08-10 09:00:00',
        ]);

        Agendamento::create([
            'user_id' => 2,
            'servico_id' => 2,
            'data_hora' => '2026-08-12 14:30:00',
        ]);

        Agendamento::create([
            'user_id' => 2,
            'servico_id' => 3,
            'data_hora' => '2026-08-15 16:00:00',
        ]);

    }
}
