<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Doutor extends Authenticatable
{
    use HasFactory;

    protected $table = 'doutores';

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
        'cidade',
        'estado',
        'telefone',
        'email',
        'password', // Alterado de 'senha' para 'password'
    ];

    protected $hidden = ['password']; // Alterado de 'senha' para 'password'
}
