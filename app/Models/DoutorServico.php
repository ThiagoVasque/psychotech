<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoutorServico extends Model
{
    protected $table = 'doutores_servicos';

    // Campos que podem ser preenchidos
    protected $fillable = [
        'titulo',
        'descricao',
        'especialidade',
        'preco',
        'doutor_cpf',
        'data_inicio_periodo',
        'data_fim_periodo',
        'hora_inicio',
        'hora_fim'
    ];

    // Casts para manipulação de datas
    protected $casts = [
        'data_inicio_periodo' => 'date',
        'data_fim_periodo' => 'date',
        'hora_inicio' => 'string',
        'hora_fim' => 'string',
    ];

    // Relacionamento com o modelo Doutor
    public function doutor()
    {
        return $this->belongsTo(Doutor::class, 'doutor_cpf', 'cpf')->withDefault();
    }

}
