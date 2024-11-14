<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diario extends Model
{
    use HasFactory;

    protected $table = 'diarios';

    protected $fillable = ['paciente_cpf', 'titulo', 'texto'];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_cpf', 'cpf');
    }
}
