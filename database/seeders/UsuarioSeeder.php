<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        // Admin fixo
        Usuario::create([
            'nome'            => 'Admin',
            'email'           => 'admin@eclipse.com',
            'senha'           => Hash::make('admin123'),
            'tipo'            => 'adm',
            'cpf'             => '999.999.999-99',
            'telefone'        => '(00) 00000-0000',
            'data_nascimento' => '1990-01-01',
            'endereco'        => 'Endereço padrão',
        ]);

        // 10 clientes aleatórios
        Usuario::factory()->count(10)->create(['tipo' => 'cliente']);
    }
}