<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id(); 
            $table->char('paciente_cpf', 11); 
            $table->unsignedBigInteger('slot_id'); 
            $table->timestamp('data_agendamento')->useCurrent(); 
            $table->enum('status', ['pendente', 'confirmado', 'cancelado'])->default('pendente'); 
            $table->timestamps();

            // Definindo as chaves estrangeiras
            $table->foreign('paciente_cpf')->references('cpf')->on('pacientes')->onDelete('cascade');
            $table->foreign('slot_id')->references('id')->on('slots')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('agendamentos');
    }
};
