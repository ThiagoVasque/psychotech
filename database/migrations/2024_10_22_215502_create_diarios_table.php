<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiariosTable extends Migration
{
    public function up()
    {
        Schema::create('diarios', function (Blueprint $table) {
            $table->id(); // Caso você não precise do ID, pode removê-lo
            $table->string('paciente_cpf'); // Altera para cpf
            $table->foreign('paciente_cpf')->references('cpf')->on('pacientes')->onDelete('cascade'); // Altera a referência para cpf
            $table->text('entrada');
            $table->timestamps(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('diarios');
    }
}
