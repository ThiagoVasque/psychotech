<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diario extends Model
{
    use HasFactory;

    // Definindo a tabela
    protected $table = 'diarios';

    // Campos que podem ser preenchidos
    protected $fillable = ['paciente_cpf', 'titulo', 'texto'];

    // Relacionamento com o modelo Paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_cpf', 'cpf');
    }
}
