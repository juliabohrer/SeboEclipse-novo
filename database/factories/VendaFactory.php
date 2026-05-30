<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class VendaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'usuario_id'  => Usuario::inRandomOrder()->first()->id,
            'data_venda'  => $this->faker->date(),
            'valor_total' => $this->faker->randomFloat(2, 10, 500),
        ];
    }
}