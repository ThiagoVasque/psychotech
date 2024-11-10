<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoutorServico extends Model
{
    protected $table = 'doutores_servicos'; // Nome correto da tabela
    protected $fillable = ['titulo', 'descricao', 'especialidade', 'preco', 'doutor_cpf'];

    // Relacionamento com Doutor (se necessário)
    public function doutor()
    {
        return $this->belongsTo(Doutor::class, 'doutor_cpf', 'cpf');
    }
}
