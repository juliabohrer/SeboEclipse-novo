<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompraLivroUsadoItem extends Model
{
    use HasFactory;

    protected $table = 'compra_livro_usado_itens';

    protected $fillable = [
        'compra_id',
        'livro_id',
        'titulo',
        'autor',
        'genero',
        'editora',
        'estado_conservacao',
        'preco_venda',
        'valor_pago',
    ];

    protected $casts = [
        'preco_venda' => 'float',
        'valor_pago'  => 'float',
    ];

    public function compra()
    {
        return $this->belongsTo(CompraLivroUsado::class, 'compra_id');
    }

    public function livro()
    {
        return $this->belongsTo(Livro::class, 'livro_id');
    }
}