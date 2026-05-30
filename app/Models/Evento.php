<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Evento extends Model
{
    use HasFactory;

    protected $table = 'eventos';

    protected $fillable = [
        'usuario_id',
        'titulo',
        'descricao',
        'data_hora_inicio',
        'data_hora_fim',
        'limite_pessoas',
        'valor_ingresso',
    ];

    protected $casts = [
        'data_hora_inicio' => 'datetime',
        'data_hora_fim'    => 'datetime',
        'limite_pessoas'   => 'integer',
        'valor_ingresso'   => 'float',
    ];

    // Relationships
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function inscricoes()
    {
        return $this->hasMany(InscricaoEvento::class, 'evento_id');
    }
}