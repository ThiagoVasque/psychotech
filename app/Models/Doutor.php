<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doutor extends Model
{
    use HasFactory;

    protected $table = 'doutores'; // Nome da tabela
    protected $fillable = [
        'crm',
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

    protected $hidden = ['senha'];
}
