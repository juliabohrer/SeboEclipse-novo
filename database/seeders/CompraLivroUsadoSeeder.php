<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CompraLivroUsado;

class CompraLivroUsadoSeeder extends Seeder
{
    public function run(): void
    {
        CompraLivroUsado::factory()->count(15)->create();
    }
}