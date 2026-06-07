<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InscricaoEvento extends Model
{
    use HasFactory;

    protected $table = 'inscricao_eventos';

    protected $fillable = [
        'usuario_id',
        'evento_id',
        'data_inscricao',
        'codigo_inscricao',
        'forma_pagamento',
    ];

    protected $casts = [
        'data_inscricao' => 'date',
    ];

    
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'evento_id');
    }
    
}