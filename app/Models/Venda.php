<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Venda extends Model
{
    use HasFactory;

    protected $table = 'vendas';

    protected $fillable = [
        'usuario_id',
        'data_venda',
        'valor_total',
    ];

    protected $casts = [
        'data_venda'  => 'date',
        'valor_total' => 'float',
    ];

    // Relationships
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function itensVenda()
    {
        return $this->hasMany(ItemVenda::class, 'venda_id');
    }

    public function pagamento()
    {
        return $this->hasOne(Pagamento::class, 'venda_id');
    }
}