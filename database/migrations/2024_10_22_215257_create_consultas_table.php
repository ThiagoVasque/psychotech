<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultasTable extends Migration
{
    public function up()
    {
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doutor_id')->constrained('doutores')->onDelete('cascade');
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade');
            $table->text('anotacao')->nullable(); // Anotações sobre o paciente
            $table->dateTime('data_hora'); // Data e hora da consulta
            $table->string('link_doutor'); // Link da reunião para o doutor
            $table->string('link_paciente'); // Link da reunião para o paciente
            $table->timestamps(); // Isso adiciona created_at e updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('consultas');
    }
}
