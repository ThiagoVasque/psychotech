<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiariosTable extends Migration
{
    public function up()
    {
        Schema::create('diarios', function (Blueprint $table) {
            $table->id(); 
            $table->string('paciente_cpf'); 
            $table->foreign('paciente_cpf')->references('cpf')->on('pacientes')->onDelete('cascade');
            $table->string('titulo'); 
            $table->text('texto');
            $table->timestamps(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('diarios');
    }
}
