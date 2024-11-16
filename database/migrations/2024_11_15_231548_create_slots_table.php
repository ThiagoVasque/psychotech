<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlotsTable extends Migration
{
    public function up()
    {
        Schema::create('slots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doutor_servico_id');
            $table->timestamp('data_hora');
            $table->boolean('disponivel')->default(true);
            $table->timestamps();

            $table->foreign('doutor_servico_id')->references('id')->on('doutores_servicos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('slots');
    }
}
