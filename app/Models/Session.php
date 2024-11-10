<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Session\DatabaseSessionHandler;

class Session extends Model
{
    protected $table = 'sessions';
    
    protected $fillable = ['id', 'payload', 'last_activity'];

    public $incrementing = false; // Para não usar auto-incremento

    protected $keyType = 'string'; // O tipo da chave é string para suportar CPF

}
