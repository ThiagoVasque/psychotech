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
            $table->string('doutor_cpf');
            $table->foreign('doutor_cpf')->references('cpf')->on('doutores')->onDelete('cascade');
            $table->string('paciente_cpf');
            $table->foreign('paciente_cpf')->references('cpf')->on('pacientes')->onDelete('cascade');
            $table->text('anotacao')->nullable();
            $table->dateTime('data_hora');
            $table->decimal('valor', 8, 2);
            $table->string('link_doutor', 500);
            $table->string('link_paciente', 500);
            $table->enum('status', ['pendente', 'confirmado', 'cancelado', 'desabilitado'])->default('pendente'); // Adicionada a opção 'desabilitado'
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('consultas');
    }
}
