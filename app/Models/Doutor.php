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
