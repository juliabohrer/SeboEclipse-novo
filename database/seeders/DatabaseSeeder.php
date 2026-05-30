<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UsuarioSeeder::class,
            LivroSeeder::class,
            EventoSeeder::class,
            TrocaLivroSeeder::class,
            InscricaoEventoSeeder::class,
            VendaSeeder::class,
            ItemVendaSeeder::class,
            CompraLivroUsadoSeeder::class,
            PagamentoSeeder::class,
        ]);
    }
}