<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

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
    ];

    protected $hidden = [
        'senha',
    ];

    protected $casts = [
        'data_nascimento' => 'date',
    ];

    // Necessário para o Laravel usar 'senha' no lugar de 'password'
    public function getAuthPassword()
    {
        return $this->senha;
    }

    public function getAuthPasswordName(): string
    {
        return 'senha';
    }

    // Relationships
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