<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $table = 'pacientes'; // Nome da tabela
    protected $fillable = [
        'nome',
        'data_nascimento',
        'cep',
        'cpf',
        'bairro',
        'logradouro',
        'numero',
        'complemento',
        'telefone',
        'email',
        'senha',
    ];

    protected $hidden = ['senha']; // Senha não será exibida ao serializar o modelo
}
