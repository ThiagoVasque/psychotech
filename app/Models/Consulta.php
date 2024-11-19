<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;

    protected $fillable = [
        'paciente_cpf', 
        'doutor_cpf', 
        'data_hora', 
        'status', 
        'link_doutor', 
        'link_paciente',
        'anotacao',
    ];

    // Relacionamento com o paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_cpf', 'cpf');
    }

    // Relacionamento com o doutor
    public function doutor()
    {
        return $this->belongsTo(Doutor::class, 'doutor_cpf', 'cpf');
    }
}
