<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Servico;

class ServicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Servico::create([
            'nome' => 'Maquiagem Social',
            'descricao' => 'Maquiagem para festas, eventos e comemorações.',
            'preco' => 180.00,
            'duracao_minutos' => 90,
        ]);

        Servico::create([
            'nome' => 'Maquiagem para Noiva',
            'descricao' => 'Maquiagem completa para casamento.',
            'preco' => 450.00,
            'duracao_minutos' => 180,
        ]);

        Servico::create([
            'nome' => 'Maquiagem para Debutante',
            'descricao' => 'Maquiagem para debutantes.',
            'preco' => 220.00,
            'duracao_minutos' => 120,
        ]);
    }
}
