<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Livro extends Model
{
    use HasFactory;

    protected $table = 'livros';

    protected $fillable = [
        'titulo',
        'autor',
        'genero',
        'editora',
        'imagem',
        'preco',
        'estado_conservacao',
        'disponivel',
    ];

    protected $casts = [
        'disponivel' => 'boolean',
        'preco'      => 'float',
    ];

    // Relationships
    public function trocasComoNovo()
    {
        return $this->hasMany(TrocaLivro::class, 'livro_novo_id');
    }

    public function trocasComoAntigo()
    {
        return $this->hasMany(TrocaLivro::class, 'livro_antigo_id');
    }

    public function compras()
    {
        return $this->hasMany(CompraLivroUsado::class, 'livro_id');
    }

    public function itensVenda()
    {
        return $this->hasMany(ItemVenda::class, 'livro_id');
    }
}