<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'duracao_minutos',
    ];
    // preco sempre com 2 casas decimais

    protected $casts = [
        'preco' => 'decimal:2',
    ];

    // Um serviço pode ter vários agendamentos (1 -> N)

    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class);
    }
}
