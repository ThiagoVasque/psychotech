<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Session\DatabaseSessionHandler;

class Session extends Model
{
    protected $table = 'sessions';
    
    protected $fillable = ['id', 'payload', 'last_activity'];

    public $incrementing = false; 

    protected $keyType = 'string';

}
