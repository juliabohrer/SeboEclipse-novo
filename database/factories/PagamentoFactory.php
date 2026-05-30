<?php

namespace Database\Factories;

use App\Models\Usuario;
use App\Models\Venda;
use Illuminate\Database\Eloquent\Factories\Factory;

class PagamentoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'usuario_id'      => Usuario::inRandomOrder()->first()->id,
            'venda_id'        => Venda::inRandomOrder()->first()->id,
            'status'          => $this->faker->randomElement([
                                     'pendente', 'aprovado', 'recusado', 'estornado'
                                 ]),
            'forma_pagamento' => $this->faker->randomElement([
                                     'pix', 'cartao_credito',
                                     'cartao_debito', 'dinheiro'
                                 ]),
        ];
    }
}