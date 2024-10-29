<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Doutor extends Authenticatable
{
    use HasFactory;

    protected $table = 'doutores';
    protected $primaryKey = 'cpf'; // Define CPF como chave primária
    public $incrementing = false; // Define que a chave primária não é auto-incrementável
    protected $keyType = 'string'; // Define o tipo da chave como string, caso o CPF tenha pontuação

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
        'password',
    ];

    protected $hidden = ['password'];
}
