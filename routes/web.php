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
    Route::resource('livros', LivroController::class);
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('compras', CompraLivroUsadoController::class);
    Route::resource('eventos', EventoController::class);
    Route::resource('inscricoes', InscricaoEventoController::class);
    Route::get('inscricoes/evento/{evento}', [InscricaoEventoController::class, 'porEvento'])->name('inscricoes.porEvento');
    Route::resource('itens-venda', ItemVendaController::class);
    Route::resource('pagamentos', PagamentoController::class);
    Route::resource('troca-livros', TrocaLivroController::class);
    Route::resource('vendas', VendaController::class);
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