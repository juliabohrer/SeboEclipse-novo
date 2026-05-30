<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UsuarioFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome'            => $this->faker->name(),
            'data_nascimento' => $this->faker->date('Y-m-d', '-18 years'),
            'cpf'             => $this->faker->unique()->numerify('###.###.###-##'),
            'endereco'        => $this->faker->address(),
            'telefone'        => $this->faker->phoneNumber(),
            'email'           => $this->faker->unique()->safeEmail(),
            'senha'           => Hash::make('password'),
            'tipo'            => $this->faker->randomElement(['admin', 'cliente']),
        ];
    }
}