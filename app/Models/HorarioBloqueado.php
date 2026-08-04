<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HorarioBloqueado extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'horario_bloqueados';

    protected $fillable = [
        'user_id',
        'data_hora_inicio',
        'data_hora_fim',
        'motivo',
    ];

    protected $casts = [
        'data_hora_inicio' => 'datetime',
        'data_hora_fim' => 'datetime',
    ];
}