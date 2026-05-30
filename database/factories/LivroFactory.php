<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LivroFactory extends Factory
{
    public function definition(): array
    {
        return [
            'titulo'             => $this->faker->sentence(3),
            'autor'              => $this->faker->name(),
            'genero'             => $this->faker->randomElement([
                                        'Romance', 'Ficção Científica', 'Terror',
                                        'Fantasia', 'Biografia', 'História', 'Autoajuda'
                                    ]),
            'editora'            => $this->faker->company(),
            'preco'              => $this->faker->randomFloat(2, 5, 150),
            'estado_conservacao' => $this->faker->randomElement([
                                        'Ótimo', 'Bom', 'Regular', 'Ruim'
                                    ]),
            'disponivel'         => $this->faker->boolean(80),
        ];
    }
}