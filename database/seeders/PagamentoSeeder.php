<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pagamento;

class PagamentoSeeder extends Seeder
{
    public function run(): void
    {
        Pagamento::factory()->count(15)->create();
    }
}