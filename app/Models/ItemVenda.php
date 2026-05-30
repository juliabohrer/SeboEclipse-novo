<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemVenda extends Model
{
    use HasFactory;

    protected $table = 'item_vendas';

    protected $fillable = [
        'venda_id',
        'livro_id',
        'valor_unitario',
        'quantidade',
    ];

    protected $casts = [
        'valor_unitario' => 'float',
        'quantidade'     => 'integer',
    ];

    // Relationships
    public function venda()
    {
        return $this->belongsTo(Venda::class, 'venda_id');
    }

    public function livro()
    {
        return $this->belongsTo(Livro::class, 'livro_id');
    }

    // Valor total do item (unitario * quantidade)
    public function getValorTotalAttribute()
    {
        return $this->valor_unitario * $this->quantidade;
    }
}