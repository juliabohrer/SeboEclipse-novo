<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ItemVenda;

class ItemVendaSeeder extends Seeder
{
    public function run(): void
    {
        ItemVenda::factory()->count(30)->create();
    }
}