<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TrocaLivro;

class TrocaLivroSeeder extends Seeder
{
    public function run(): void
    {
        TrocaLivro::factory()->count(10)->create();
    }
}