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

Route::get('/', function () {
    return view('welcome');
});


Route::resource('livros', LivroController::class);
Route::resource('usuarios', UsuarioController::class);
Route::resource('compras', CompraLivroUsadoController::class);
Route::resource('eventos', EventoController::class);
Route::resource('inscricoes', InscricaoEventoController::class);
Route::resource('itens-venda', ItemVendaController::class);
Route::resource('pagamentos', PagamentoController::class);
Route::resource('troca-livros', TrocaLivroController::class);
Route::resource('vendas', VendaController::class);