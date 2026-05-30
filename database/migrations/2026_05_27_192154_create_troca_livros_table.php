
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('troca_livros', function (Blueprint $table) {
            $table->id();

            $table->foreignId('livro_novo_id')
                ->constrained('livros')
                ->onDelete('cascade');

            $table->foreignId('livro_antigo_id')
                ->constrained('livros')
                ->onDelete('cascade');

            $table->foreignId('usuario_id')
                ->constrained('usuarios')
                ->onDelete('cascade');

            $table->string('valor_pago');

            $table->boolean('disponivel')->default(true);

            $table->string('status');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('troca_livros');
    }
};
