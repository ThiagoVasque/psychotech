<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoutorServico extends Model
{
    use HasFactory;

    protected $table = 'doutores_servicos';  
    
    // Campos que podem ser preenchidos
    protected $fillable = [
        'doutor_cpf', 'titulo', 'descricao', 'preco', 'hora_inicio', 'hora_fim', 'periodos'
    ];
    
    protected $casts = [
        'periodos' => 'array',
    ];

    public function slots()
{
    // relacionamento com o model Slot
    return $this->hasMany(Slot::class, 'doutor_servico_id'); 
}
}