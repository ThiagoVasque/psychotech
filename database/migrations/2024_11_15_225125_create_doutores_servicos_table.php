<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('doutores_servicos', function (Blueprint $table) {
            $table->id();
            $table->char('doutor_cpf', 11);
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->decimal('preco', 8, 2);
            $table->json('periodos')->nullable();  
            $table->timestamps();

            // Chave estrangeira
            $table->foreign('doutor_cpf')->references('cpf')->on('doutores')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doutores_servicos');
    }
};
