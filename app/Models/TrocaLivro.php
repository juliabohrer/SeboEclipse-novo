<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrocaLivro extends Model
{
    use HasFactory;

    protected $table = 'troca_livros';

    protected $fillable = [
        'livro_novo_id',
        'livro_antigo_id',
        'usuario_id',
        'valor_pago',
        'disponivel',
        'status',
    ];

    protected $casts = [
        'disponivel' => 'boolean',
    ];

    // Relationships
    public function livroNovo()
    {
        return $this->belongsTo(Livro::class, 'livro_novo_id');
    }

    public function livroAntigo()
    {
        return $this->belongsTo(Livro::class, 'livro_antigo_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}