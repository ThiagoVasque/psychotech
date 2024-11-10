<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoutoresServicosTable extends Migration
{
    public function up()
    {
        Schema::create('doutores_servicos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao');
            $table->string('especialidade');
            $table->decimal('preco', 8, 2);  // Valor do serviço
            $table->string('doutor_cpf');
            $table->timestamps();

            // Adiciona chave estrangeira para o CPF do doutor (se for necessário)
            $table->foreign('doutor_cpf')->references('cpf')->on('doutores')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('doutores_servicos');
    }
}
