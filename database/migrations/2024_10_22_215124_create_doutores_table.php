<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoutoresTable extends Migration
{
    public function up()
    {
        Schema::create('doutores', function (Blueprint $table) {
            $table->id();
            $table->string('crm')->unique();
            $table->string('nome');
            $table->date('data_nascimento');
            $table->string('cep');
            $table->string('cpf')->unique();
            $table->string('bairro');
            $table->string('logradouro');
            $table->string('numero');
            $table->string('complemento')->nullable();
            $table->string('telefone');
            $table->string('email')->unique();
            $table->string('senha');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('doutores');
    }
}
