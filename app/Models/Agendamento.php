<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'paciente_cpf', 
        'slot_id', 
        'data_agendamento', 
        'status'
    ];

    // Relacionamento com o paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_cpf', 'cpf');
    }

    // Relacionamento com o slot
    public function slot()
    {
        return $this->belongsTo(Slot::class, 'slot_id');
    }
}
