<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Doutor extends Authenticatable
{
    use HasFactory;

    protected $table = 'doutores';
    protected $primaryKey = 'cpf';
    public $incrementing = false;
    protected $keyType = 'string';


    public function servicos()
    {
        return $this->hasMany(DoutorServico::class, 'doutor_cpf', 'cpf');
    }

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
