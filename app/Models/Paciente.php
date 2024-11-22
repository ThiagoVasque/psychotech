<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Paciente extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pacientes';
    protected $primaryKey = 'cpf';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nome',
        'data_nascimento',
        'foto_perfil', 
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

    // Relacionamento com agendamentos
    public function agendamentos()
    {
        return $this->hasMany(Consulta::class, 'paciente_cpf', 'cpf');
    }
}
