<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        // Admin fixo para testes
        Usuario::create([
            'nome'            => 'Admin',
            'data_nascimento' => '1990-01-01',
            'cpf'             => '000.000.000-00',
            'endereco'        => 'Rua Admin, 1',
            'telefone'        => '(41) 99999-9999',
            'email'           => 'admin@sebo.com',
            'senha'           => Hash::make('password'),
            'tipo'            => 'admin',
        ]);

        // Clientes aleatórios
        Usuario::factory()->count(10)->create(['tipo' => 'cliente']);
    }
}