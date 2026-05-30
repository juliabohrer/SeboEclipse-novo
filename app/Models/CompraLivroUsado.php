<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompraLivroUsado extends Model
{
    use HasFactory;

    protected $table = 'compra_livro_usados';

    protected $fillable = [
        'usuario_id',
        'livro_id',
        'data',
        'valor_pago',
    ];

    protected $casts = [
        'data'       => 'date',
        'valor_pago' => 'float',
    ];

    // Relationships
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function livro()
    {
        return $this->belongsTo(Livro::class, 'livro_id');
    }
}