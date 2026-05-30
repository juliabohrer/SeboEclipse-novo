<?php

namespace Database\Factories;

use App\Models\Usuario;
use App\Models\Evento;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class InscricaoEventoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'usuario_id'       => Usuario::inRandomOrder()->first()->id,
            'evento_id'        => Evento::inRandomOrder()->first()->id,
            'data_inscricao'   => $this->faker->date(),
            'codigo_inscricao' => strtoupper(Str::random(8)),
            'forma_pagamento'  => $this->faker->randomElement([
                                      'pix', 'cartao_credito',
                                      'cartao_debito', 'dinheiro'
                                  ]),
        ];
    }
}