<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacientesTable extends Migration
{
    public function up()
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->string('cpf')->primary(); // Define CPF como chave primária
            $table->string('nome');
            $table->date('data_nascimento');
            $table->string('cep');
            $table->string('bairro');
            $table->string('logradouro');
            $table->string('numero');
            $table->string('complemento')->nullable();
            $table->string('cidade'); // Adiciona o campo de cidade
            $table->string('estado'); // Adiciona o campo de estado
            $table->string('telefone');
            $table->string('email')->unique();
            $table->string('password'); // Mudança de 'senha' para 'password'
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pacientes');
    }
}
