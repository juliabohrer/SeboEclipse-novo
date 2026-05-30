<?php

namespace Database\Factories;

use App\Models\Usuario;
use App\Models\Livro;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompraLivroUsadoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'usuario_id' => Usuario::inRandomOrder()->first()->id,
            'livro_id'   => Livro::inRandomOrder()->first()->id,
            'data'       => $this->faker->date(),
            'valor_pago' => $this->faker->randomFloat(2, 5, 150),
        ];
    }
}