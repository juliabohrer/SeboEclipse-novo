<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\EntregaController;

use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Produto;
use App\Models\Pedido;

Route::get('/', function () {

    return view('welcome');

});

Route::get('/pdf-produtos', function () {

    $dados = Produto::all();

    $pdf = Pdf::loadView(
        'relatorios.produtos',
        compact('dados')
    );

    return $pdf->download(
        'relatorio_produtos.pdf'
    );

})->name('pdf.produtos');

Route::get('/pdf-pedidos', function () {

    $dados = Pedido::with([
        'funcionario',
        'entrega'
    ])->get();

    $pdf = Pdf::loadView(
        'relatorios.pedidos',
        compact('dados')
    );

    return $pdf->download(
        'relatorio_pedidos.pdf'
    );

})->name('pdf.pedidos');

Route::get(
    '/pedido/graficos',
    [PedidoController::class, 'graficos']
)->name('pedido.graficos');

Route::get('/produto', [ProdutoController::class, 'index'])
    ->name('produto.index');

Route::get('/produto/create', [ProdutoController::class, 'create'])
    ->name('produto.create');

Route::post('/produto', [ProdutoController::class, 'store'])
    ->name('produto.store');

Route::get('/produto/edit/{id}', [ProdutoController::class, 'edit'])
    ->name('produto.edit');

Route::put('/produto/update/{id}', [ProdutoController::class, 'update'])
    ->name('produto.update');

Route::delete('/produto/{id}', [ProdutoController::class, 'destroy'])
    ->name('produto.destroy');

Route::get('/produto/search', [ProdutoController::class, 'search'])
    ->name('produto.search');






Route::get('/funcionario', [FuncionarioController::class, 'index'])
    ->name('funcionario.index');

Route::get('/funcionario/create', [FuncionarioController::class, 'create'])
    ->name('funcionario.create');

Route::post('/funcionario', [FuncionarioController::class, 'store'])
    ->name('funcionario.store');

Route::get('/funcionario/edit/{id}', [FuncionarioController::class, 'edit'])
    ->name('funcionario.edit');

Route::put('/funcionario/update/{id}', [FuncionarioController::class, 'update'])
    ->name('funcionario.update');

Route::delete('/funcionario/{id}', [FuncionarioController::class, 'destroy'])
    ->name('funcionario.destroy');

Route::post('/funcionario/search', [FuncionarioController::class, 'search'])
    ->name('funcionario.search');





Route::get('/pedido', [PedidoController::class, 'index'])
    ->name('pedido.index');

Route::get('/pedido/create', [PedidoController::class, 'create'])
    ->name('pedido.create');

Route::post('/pedido', [PedidoController::class, 'store'])
    ->name('pedido.store');

Route::get('/pedido/edit/{id}', [PedidoController::class, 'edit'])
    ->name('pedido.edit');

Route::put('/pedido/update/{id}', [PedidoController::class, 'update'])
    ->name('pedido.update');

Route::get('/pedido/search', [PedidoController::class, 'search'])
    ->name('pedido.search');

Route::delete('/pedido/{id}', [PedidoController::class, 'destroy'])
    ->name('pedido.destroy');





Route::get('/fornecedor', [FornecedorController::class, 'index'])
    ->name('fornecedor.index');

Route::get('/fornecedor/create', [FornecedorController::class, 'create'])
    ->name('fornecedor.create');

Route::post('/fornecedor', [FornecedorController::class, 'store'])
    ->name('fornecedor.store');

Route::get('/fornecedor/edit/{id}', [FornecedorController::class, 'edit'])
    ->name('fornecedor.edit');

Route::put('/fornecedor/update/{id}', [FornecedorController::class, 'update'])
    ->name('fornecedor.update');

Route::delete('/fornecedor/{id}', [FornecedorController::class, 'destroy'])
    ->name('fornecedor.destroy');

Route::get('/fornecedor/search', [FornecedorController::class, 'search'])
    ->name('fornecedor.search');




    

Route::get('/entrega', [EntregaController::class, 'index'])
    ->name('entrega.index');

Route::get('/entrega/create', [EntregaController::class, 'create'])
    ->name('entrega.create');

Route::post('/entrega', [EntregaController::class, 'store'])
    ->name('entrega.store');

Route::get('/entrega/{id}/edit', [EntregaController::class, 'edit'])
    ->name('entrega.edit');

Route::put('/entrega/{id}', [EntregaController::class, 'update'])
    ->name('entrega.update');

Route::delete('/entrega/{id}', [EntregaController::class, 'destroy'])
    ->name('entrega.destroy');

Route::get('/entrega/search', [EntregaController::class, 'search'])
    ->name('entrega.search');