<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    use HasFactory;

    protected $table = 'slots';

    protected $fillable = ['doutor_servico_id', 'data_hora', 'disponivel']; 

    // Relacionamento com DoutorServico
    public function doutorServico()
    {
        return $this->belongsTo(DoutorServico::class, 'doutor_servico_id'); 
    }
}
