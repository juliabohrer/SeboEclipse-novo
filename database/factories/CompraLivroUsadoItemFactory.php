<?php

namespace Database\Factories;

use App\Models\CompraLivroUsado;
use App\Models\CompraLivroUsadoItem;
use App\Models\Livro;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompraLivroUsadoItemFactory extends Factory
{
    protected $model = CompraLivroUsadoItem::class;

    public function definition(): array
    {
        $precoVenda = $this->faker->randomFloat(2, 10, 100);
        $valorPago  = $this->faker->randomFloat(2, 5, $precoVenda);

        return [
            'compra_id'          => CompraLivroUsado::inRandomOrder()->first()?->id
                                    ?? CompraLivroUsado::factory(),
            'livro_id'           => Livro::inRandomOrder()->first()?->id,
            'titulo'             => $this->faker->sentence(3),
            'autor'              => $this->faker->name(),
            'genero'             => $this->faker->randomElement([
                                        'Romance', 'Ficção', 'Terror',
                                        'Aventura', 'Biografia', 'Infantil',
                                    ]),
            'editora'            => $this->faker->company(),
            'estado_conservacao' => $this->faker->randomElement([
                                        'Novo', 'Ótimo', 'Bom', 'Regular', 'Ruim',
                                    ]),
            'preco_venda'        => $precoVenda,
            'valor_pago'         => $valorPago,
        ];
    }
}