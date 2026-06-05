<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompraLivroUsado extends Model
{
    use HasFactory;

    protected $table = 'compra_livro_usados'; // corrigido!

    protected $fillable = [
        'usuario_id',
        'fornecedor',
        'data',
        'valor_total',
    ];

    protected $casts = [
        'data'        => 'date',
        'valor_total' => 'float',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function itens()
    {
        return $this->hasMany(CompraLivroUsadoItem::class, 'compra_id');
    }
}