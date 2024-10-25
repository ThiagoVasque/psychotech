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
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade');
            $table->text('entrada');
            $table->timestamps(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('diarios');
    }
}
