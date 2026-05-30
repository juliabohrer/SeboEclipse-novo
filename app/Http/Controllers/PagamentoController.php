<?php

namespace App\Http\Controllers;

use App\Models\Pagamento;
use App\Models\Usuario;
use App\Models\Venda;
use Illuminate\Http\Request;

class PagamentoController extends Controller
{
    public function index()
    {
        $pagamentos = Pagamento::with(['usuario', 'venda'])->get();
        return view('pagamentos.index', compact('pagamentos'));
    }

    public function create()
    {
        $usuarios = Usuario::all();
        $vendas   = Venda::all();
        return view('pagamentos.create', compact('usuarios', 'vendas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'usuario_id'      => 'required|exists:usuarios,id',
            'venda_id'        => 'required|exists:vendas,id|unique:pagamentos,venda_id',
            'status'          => 'required|in:pendente,aprovado,recusado,estornado',
            'forma_pagamento' => 'required|in:pix,cartao_credito,cartao_debito,dinheiro',
        ]);

        Pagamento::create($validated);

        return redirect()->route('pagamentos.index')
                         ->with('success', 'Pagamento registrado com sucesso!');
    }

    public function show(Pagamento $pagamento)
    {
        $pagamento->load('usuario', 'venda.itensVenda.livro');
        return view('pagamentos.show', compact('pagamento'));
    }

    public function edit(Pagamento $pagamento)
    {
        $usuarios = Usuario::all();
        $vendas   = Venda::all();
        return view('pagamentos.edit', compact('pagamento', 'usuarios', 'vendas'));
    }

    public function update(Request $request, Pagamento $pagamento)
    {
        $validated = $request->validate([
            'usuario_id'      => 'required|exists:usuarios,id',
            'venda_id'        => 'required|exists:vendas,id|unique:pagamentos,venda_id,' . $pagamento->id,
            'status'          => 'required|in:pendente,aprovado,recusado,estornado',
            'forma_pagamento' => 'required|in:pix,cartao_credito,cartao_debito,dinheiro',
        ]);

        $pagamento->update($validated);

        return redirect()->route('pagamentos.index')
                         ->with('success', 'Pagamento atualizado com sucesso!');
    }

    public function destroy(Pagamento $pagamento)
    {
        $pagamento->delete();

        return redirect()->route('pagamentos.index')
                         ->with('success', 'Pagamento removido com sucesso!');
    }
}