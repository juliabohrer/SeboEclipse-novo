<?php

namespace Database\Factories;

use App\Models\Compra;
use App\Models\CompraItem;
use App\Models\Livro;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompraItemFactory extends Factory
{
    protected $model = CompraItem::class;

    public function definition(): array
    {
        $precoVenda = $this->faker->randomFloat(2, 10, 100);
        $valorPago  = $this->faker->randomFloat(2, 5, $precoVenda);

        return [
            'compra_id'          => Compra::inRandomOrder()->first()?->id
                                    ?? Compra::factory(),
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