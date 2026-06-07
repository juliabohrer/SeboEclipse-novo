<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CompraLivroUsadoController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\InscricaoEventoController;
use App\Http\Controllers\ItemVendaController;
use App\Http\Controllers\PagamentoController;
use App\Http\Controllers\TrocaLivroController;
use App\Http\Controllers\VendaController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/cadastro', [UsuarioController::class, 'create'])->name('cadastro');
Route::post('/cadastro', [UsuarioController::class, 'store'])->name('cadastro.store');

// Rotas do ADMIN
Route::middleware(['auth', 'check.tipo:adm'])->group(function () {

    Route::get('livros/search', [LivroController::class, 'search'])->name('livros.search');
    Route::resource('livros', LivroController::class)->except(['show']);

    Route::resource('usuarios', UsuarioController::class)->except(['show']);

    Route::get('compras/search', [CompraLivroUsadoController::class, 'search'])->name('compras.search');
    Route::resource('compras', CompraLivroUsadoController::class)->except(['show']);

    Route::get('eventos/search', [EventoController::class, 'search'])->name('eventos.search');
    Route::resource('eventos', EventoController::class)->except(['show']);

    Route::get('inscricoes/search', [InscricaoEventoController::class, 'search'])->name('inscricoes.search');
    Route::get('inscricoes/evento/{evento}', [InscricaoEventoController::class, 'porEvento'])->name('inscricoes.porEvento'); // 👈 novo
    Route::resource('inscricoes', InscricaoEventoController::class)->except(['show']);

    Route::get('vendas/search', [VendaController::class, 'search'])->name('vendas.search');
    Route::resource('vendas', VendaController::class)->except(['show']);

    Route::resource('itens-venda', ItemVendaController::class)->except(['show']);
    Route::resource('pagamentos', PagamentoController::class)->except(['show']);
    Route::resource('troca-livros', TrocaLivroController::class)->except(['show']);
});

// Rotas do CLIENTE
Route::middleware(['auth', 'check.tipo:cliente'])->prefix('cliente')->name('cliente.')->group(function () {
    Route::get('/',        [LivroController::class, 'index'])->name('home');
    Route::get('/livros',  [LivroController::class, 'index'])->name('livros');
    Route::get('/eventos', [EventoController::class, 'index'])->name('eventos');
    Route::get('/trocas',  [TrocaLivroController::class, 'index'])->name('trocas');
    Route::get('/perfil',  [UsuarioController::class, 'editPerfil'])->name('perfil');
    Route::put('/perfil',  [UsuarioController::class, 'updatePerfil'])->name('perfil.update');
    Route::post('/inscricoes', [InscricaoEventoController::class, 'store'])->name('inscricoes.store');
    Route::get('/evento/{evento}/inscrever', [InscricaoEventoController::class, 'createCliente'])->name('inscricoes.form');
});