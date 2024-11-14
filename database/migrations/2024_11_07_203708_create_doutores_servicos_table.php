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
            $table->decimal('preco', 8, 2);
            $table->string('doutor_cpf');
            $table->date('data_inicio_periodo');
            $table->date('data_fim_periodo');
            $table->time('hora_inicio');
            $table->time('hora_fim');
            $table->timestamps();

            // Definindo a chave estrangeira para doutores
            $table->foreign('doutor_cpf')->references('cpf')->on('doutores')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('doutores_servicos');
    }
}
