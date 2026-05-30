<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Venda;

class VendaSeeder extends Seeder
{
    public function run(): void
    {
        Venda::factory()->count(15)->create();
    }
}