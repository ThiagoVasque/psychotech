<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    use HasFactory;

    protected $fillable = [
        'doutor_servico_id', 'data_hora', 'disponivel', 'paciente_cpf'
    ];

    public $timestamps = false;

    // Relacionamento com DoutorServico
    public function doutorServico()
    {
        return $this->belongsTo(DoutorServico::class);
    }

    // Relacionamento com Paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}


