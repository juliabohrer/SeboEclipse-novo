<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompraFactory extends Factory
{
    public function definition(): array
    {
        return [
            'usuario_id'  => Usuario::inRandomOrder()->first()?->id
                             ?? Usuario::factory(),
            'fornecedor'  => $this->faker->company(),
            'data'        => $this->faker->dateTimeBetween('2025-01-01', 'now'),
            'valor_total' => $this->faker->randomFloat(2, 20, 500),
        ];
    }
}