<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Livro;
use App\Models\Compra;
use App\Models\ItemCompra;
use Illuminate\Support\Facades\DB;

class CompraSeeder extends Seeder
{
    public function run(): void
    {
        Compra::factory()->count(15)->create()->each(function ($compra) {
            $quantidade = rand(1, 5);

            for ($i = 0; $i < $quantidade; $i++) {
                $precoVenda = fake()->randomFloat(2, 10, 100);
                $valorPago  = fake()->randomFloat(2, 5, $precoVenda);

                $livro = Livro::create([
                    'titulo'             => fake()->sentence(3),
                    'autor'              => fake()->name(),
                    'genero'             => fake()->randomElement(['Romance', 'Ficção', 'Terror', 'Aventura', 'Biografia']),
                    'editora'            => fake()->company(),
                    'preco'              => $precoVenda,
                    'estado_conservacao' => fake()->randomElement(['Ótimo', 'Bom', 'Regular', 'Ruim']),
                    'disponivel'         => true,
                ]);

                ItemCompra::create([
                    'compra_id'          => $compra->id,
                    'livro_id'           => $livro->id,
                    'titulo'             => $livro->titulo,
                    'autor'              => $livro->autor,
                    'genero'             => $livro->genero,
                    'editora'            => $livro->editora,
                    'estado_conservacao' => $livro->estado_conservacao,
                    'preco_venda'        => $precoVenda,
                    'valor_pago'         => $valorPago,
                ]);
            }
        });
    }
}
