<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agendamento extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'servico_id',
        'data_hora',
    ];

    // protected $casts = [ ... ];: É um recurso do Eloquent que diz ao Laravel para converter automaticamente o tipo de dado de uma coluna assim que você a busca no banco.

    //'data_hora' => 'datetime': Informa que a coluna data_hora deve ser transformada em um objeto da biblioteca Carbon (o padrão do PHP para datas).
    
    protected $casts = [
        'data_hora' => 'datetime',
    ];

    // // Cliente dona do agendamento (N agendamentos -> 1 usuário)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Serviço contratado (N agendamentos -> 1 serviço)
    public function servico()
    {
        return $this->belongsTo(Servico::class);
    }
}