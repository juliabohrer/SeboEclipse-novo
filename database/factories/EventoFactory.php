<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventoFactory extends Factory
{
    public function definition(): array
    {
        $inicio = $this->faker->dateTimeBetween('+1 week', '+3 months');
        $fim    = (clone $inicio)->modify('+3 hours');

        return [
            'usuario_id'       => Usuario::factory(),
            'titulo'           => $this->faker->sentence(4),
            'descricao'        => $this->faker->paragraph(),
            'data_hora_inicio' => $inicio,
            'data_hora_fim'    => $fim,
            'limite_pessoas'   => $this->faker->numberBetween(10, 200),
            'valor_ingresso'   => $this->faker->randomFloat(2, 0, 150),
        ];
    }
}