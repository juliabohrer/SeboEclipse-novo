<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemCompra extends Model
{
    use HasFactory;

    protected $table = 'item_compra';

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
        return $this->belongsTo(Compra::class, 'compra_id');
    }

    public function livro()
    {
        return $this->belongsTo(Livro::class, 'livro_id');
    }
}