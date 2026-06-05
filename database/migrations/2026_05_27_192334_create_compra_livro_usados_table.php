<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('compra_livro_usados', function (Blueprint $table) {
            $table->id();

            $table->foreignId('usuario_id')
                ->constrained('usuarios')
                ->onDelete('cascade');

            $table->string('fornecedor')->nullable();
            $table->date('data');
            $table->float('valor_total')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compra_livro_usados');
    }
};