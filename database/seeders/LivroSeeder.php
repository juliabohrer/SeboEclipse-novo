<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Livro;

class LivroSeeder extends Seeder
{
    public function run(): void
    {
        Livro::factory()->count(20)->create();
    }
}