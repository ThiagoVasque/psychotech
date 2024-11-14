<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    protected $fillable = ['doutor_cpf', 'nome', 'descricao', 'preco'];
    public function doutor()
    {
        return $this->belongsTo(Doutor::class, 'doutor_cpf', 'cpf');
    }
}
