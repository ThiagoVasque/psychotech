<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Doutor extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'doutores';
    protected $primaryKey = 'cpf';
    public $incrementing = false;
    protected $keyType = 'string';

    // Relacionamento com os serviços
    public function servicos()
    {
        return $this->hasMany(DoutorServico::class, 'doutor_cpf', 'cpf');
    }

    // Relacionamento com slots disponíveis
    public function consultasDisponiveis()
    {
        return $this->hasManyThrough(
            Slot::class,
            DoutorServico::class,
            'doutor_cpf',
            'doutor_servico_id',
            'cpf',
            'id'
        );
    }

    protected $fillable = [
        'crm',
        'nome',
        'especialidade',
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
}
