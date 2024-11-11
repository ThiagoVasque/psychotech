<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaDoutor extends Model
{
    use HasFactory;

    protected $table = 'agenda_doutor';
    protected $fillable = [
        'doutor_cpf', 
        'data_hora_inicio', 
        'data_hora_fim', 
        'status', 
    ];
}
