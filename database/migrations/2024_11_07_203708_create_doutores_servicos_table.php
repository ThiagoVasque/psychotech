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
            $table->json('agenda_horarios')->nullable();
            $table->timestamps();
            $table->foreign('doutor_cpf')->references('cpf')->on('doutores')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('doutores_servicos');
    }
}
