<?php

namespace App\Http\Controllers;

use App\Models\ItemVenda;
use App\Models\Venda;
use App\Models\Livro;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ItemVendaController extends Controller
{
    public function index()
    {
        $itens = ItemVenda::with(['venda', 'livro'])->get();
        return view('itens-venda.index', compact('itens'));
    }

    public function create()
    {
        $vendas = Venda::all();
        $livros = Livro::where('disponivel', true)->get();
        return view('itens-venda.create', compact('vendas', 'livros'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'venda_id'       => 'required|exists:vendas,id',
            'livro_id'       => 'required|exists:livros,id',
            'valor_unitario' => 'required|numeric|min:0',
            'quantidade'     => 'required|integer|min:1',
        ]);

        $item = ItemVenda::create($validated);

        $venda = Venda::find($validated['venda_id']);
        $venda->valor_total = $venda->itensVenda->sum(fn($i) => $i->valor_unitario * $i->quantidade);
        $venda->save();

        Livro::find($validated['livro_id'])->update(['disponivel' => false]);

        return redirect()->route('itens-venda.index')
                         ->with('success', 'Item adicionado à venda com sucesso!');
    }

    public function show(ItemVenda $itensVenda)
    {
        $itensVenda->load('venda', 'livro');
        return view('itens-venda.show', compact('itensVenda'));
    }

    public function edit(ItemVenda $itensVenda)
    {
        $vendas = Venda::all();
        $livros = Livro::all();
        return view('itens-venda.edit', compact('itensVenda', 'vendas', 'livros'));
    }

    public function update(Request $request, ItemVenda $itensVenda)
    {
        $validated = $request->validate([
            'venda_id'       => 'required|exists:vendas,id',
            'livro_id'       => 'required|exists:livros,id',
            'valor_unitario' => 'required|numeric|min:0',
            'quantidade'     => 'required|integer|min:1',
        ]);

        $itensVenda->update($validated);

        $venda = Venda::find($validated['venda_id']);
        $venda->valor_total = $venda->itensVenda->sum(fn($i) => $i->valor_unitario * $i->quantidade);
        $venda->save();

        return redirect()->route('itens-venda.index')
                         ->with('success', 'Item atualizado com sucesso!');
    }

    public function destroy(ItemVenda $itensVenda)
    {
        $venda = $itensVenda->venda;
        $livro = $itensVenda->livro;

        $itensVenda->delete();

        $venda->valor_total = $venda->itensVenda->sum(fn($i) => $i->valor_unitario * $i->quantidade);
        $venda->save();

        $livro->update(['disponivel' => true]);

        return redirect()->route('itens-venda.index')
                         ->with('success', 'Item removido com sucesso!');
    }
}