<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('compra_livro_usado_itens', function (Blueprint $table) {
            $table->id();

            $table->foreignId('compra_id')
                ->constrained('compra_livro_usados')
                ->onDelete('cascade');

            $table->foreignId('livro_id')
                ->nullable()
                ->constrained('livros')
                ->onDelete('set null');

            $table->string('titulo');
            $table->string('autor');
            $table->string('genero');
            $table->string('editora');
            $table->string('estado_conservacao');
            $table->float('preco_venda');
            $table->float('valor_pago');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compra_livro_usado_itens');
    }
};