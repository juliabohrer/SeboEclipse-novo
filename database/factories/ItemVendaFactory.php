<?php

namespace Database\Factories;

use App\Models\Venda;
use App\Models\Livro;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemVendaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'venda_id'       => Venda::inRandomOrder()->first()->id,
            'livro_id'       => Livro::inRandomOrder()->first()->id,
            'valor_unitario' => $this->faker->randomFloat(2, 5, 150),
            'quantidade'     => $this->faker->numberBetween(1, 5),
        ];
    }
}