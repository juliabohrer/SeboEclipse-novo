<?php

namespace Database\Factories;

use App\Models\Livro;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrocaLivroFactory extends Factory
{
    public function definition(): array
    {
        $livros = Livro::pluck('id')->toArray();

        $livroNovo   = $this->faker->randomElement($livros);
        $livroAntigo = $this->faker->randomElement(
            array_filter($livros, fn($id) => $id !== $livroNovo)
        );

        return [
            'livro_novo_id'  => $livroNovo,
            'livro_antigo_id'=> $livroAntigo,
            'usuario_id'     => Usuario::inRandomOrder()->first()->id,
            'valor_pago'     => $this->faker->randomFloat(2, 0, 100),
            'disponivel'     => $this->faker->boolean(70),
            'status'         => $this->faker->randomElement([
                                    'pendente', 'aprovada', 'recusada', 'concluida'
                                ]),
        ];
    }
}