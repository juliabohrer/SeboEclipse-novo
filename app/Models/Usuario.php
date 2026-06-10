<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nome',
        'data_nascimento',
        'cpf',
        'endereco',
        'telefone',
        'email',
        'senha',
        'tipo',
        'imagem',
    ];

    protected $hidden = [
        'senha',
    ];

    protected $casts = [
        'data_nascimento' => 'date',
    ];

    public function getAuthPassword()
    {
        return $this->senha;
    }

    public function getAuthPasswordName(): string
    {
        return 'senha';
    }

    public function getImagemUrlAttribute(): string
    {
        if ($this->imagem && Storage::disk('public')->exists($this->imagem)) {
            return asset('storage/' . $this->imagem);
        }
        return asset('images/sem-imagem.png');
    }

    public function trocas()
    {
        return $this->hasMany(TrocaLivro::class, 'usuario_id');
    }

    public function compras()
    {
        return $this->hasMany(CompraLivroUsado::class, 'usuario_id');
    }

    public function vendas()
    {
        return $this->hasMany(Venda::class, 'usuario_id');
    }

    public function pagamentos()
    {
        return $this->hasMany(Pagamento::class, 'usuario_id');
    }

    public function eventos()
    {
        return $this->hasMany(Evento::class, 'usuario_id');
    }

    public function inscricoes()
    {
        return $this->hasMany(InscricaoEvento::class, 'usuario_id');
    }
}