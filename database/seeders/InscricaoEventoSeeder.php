<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InscricaoEvento;

class InscricaoEventoSeeder extends Seeder
{
    public function run(): void
    {
        InscricaoEvento::factory()->count(15)->create();
    }
}