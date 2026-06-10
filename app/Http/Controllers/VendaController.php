<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\Usuario;
use App\Models\Livro;
use App\Models\ItemVenda;
use App\Models\Pagamento;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class VendaController extends Controller
{
    public function index()
    {
        $vendas = Venda::with([
            'usuario',
            'itensVenda.livro',
            'pagamento'
        ])->get();

        return view('vendas.list', compact('vendas'));
    }

    public function search(Request $request)
    {
        $search = trim($request->input('search', ''));

        $query = Venda::with(['usuario', 'itensVenda.livro', 'pagamento']);

        if ($search) {
            foreach (explode(' ', $search) as $palavra) {
                if ($palavra === '') continue;
                $query->where(function ($q) use ($palavra) {
                    $q->whereHas('usuario', function ($u) use ($palavra) {
                        $u->where('nome', 'like', "%{$palavra}%");
                    })
                    ->orWhereHas('itensVenda.livro', function ($l) use ($palavra) {
                        $l->where('titulo', 'like', "%{$palavra}%")
                          ->orWhere('autor', 'like', "%{$palavra}%");
                    });
                });
            }
        }

        $vendas = $query->get();

        return view('vendas.list', compact('vendas'));
    }

    public function create()
    {
        $usuarios = Usuario::all();
        $livros   = Livro::all();

        return view('vendas.form', compact('usuarios', 'livros'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'usuario_id'             => 'required|exists:usuarios,id',
            'data_venda'             => 'required|date',
            'valor_total'            => 'required|numeric|min:0',
            'itens'                  => 'required|array|min:1',
            'itens.*.livro_id'       => 'required|exists:livros,id',
            'itens.*.quantidade'     => 'required|integer|min:1',
            'itens.*.valor_unitario' => 'required|numeric|min:0',
            'forma_pagamento'        => 'nullable|string|max:255',
            'status_pagamento'       => 'nullable|string|max:255',
        ]);

        $venda = Venda::create([
            'usuario_id'  => $validated['usuario_id'],
            'data_venda'  => $validated['data_venda'],
            'valor_total' => $validated['valor_total'],
        ]);

        foreach ($validated['itens'] as $item) {
            ItemVenda::create([
                'venda_id'       => $venda->id,
                'livro_id'       => $item['livro_id'],
                'quantidade'     => $item['quantidade'],
                'valor_unitario' => $item['valor_unitario'],
            ]);
        }

        Pagamento::create([
            'usuario_id'      => $validated['usuario_id'],
            'venda_id'        => $venda->id,
            'forma_pagamento' => $validated['forma_pagamento'] ?? null,
            'status'          => $validated['status_pagamento'] ?? 'Pendente',
        ]);

        return redirect()
            ->route('vendas.index')
            ->with('success', 'Venda cadastrada com sucesso!');
    }

    public function edit(Venda $venda)
    {
        $usuarios = Usuario::all();
        $livros   = Livro::all();

        return view('vendas.form', compact('venda', 'usuarios', 'livros'));
    }

    public function update(Request $request, Venda $venda)
    {
        $validated = $request->validate([
            'usuario_id'             => 'required|exists:usuarios,id',
            'data_venda'             => 'required|date',
            'valor_total'            => 'required|numeric|min:0',
            'itens'                  => 'required|array|min:1',
            'itens.*.livro_id'       => 'required|exists:livros,id',
            'itens.*.quantidade'     => 'required|integer|min:1',
            'itens.*.valor_unitario' => 'required|numeric|min:0',
            'forma_pagamento'        => 'nullable|string|max:255',
            'status_pagamento'       => 'nullable|string|max:255',
        ]);

        $venda->update([
            'usuario_id'  => $validated['usuario_id'],
            'data_venda'  => $validated['data_venda'],
            'valor_total' => $validated['valor_total'],
        ]);

        $venda->itensVenda()->delete();
        foreach ($validated['itens'] as $item) {
            ItemVenda::create([
                'venda_id'       => $venda->id,
                'livro_id'       => $item['livro_id'],
                'quantidade'     => $item['quantidade'],
                'valor_unitario' => $item['valor_unitario'],
            ]);
        }

        $venda->pagamento()->updateOrCreate(
            ['venda_id' => $venda->id],
            [
                'usuario_id'      => $validated['usuario_id'],
                'forma_pagamento' => $validated['forma_pagamento'] ?? null,
                'status'          => $validated['status_pagamento'] ?? 'Pendente',
            ]
        );

        return redirect()
            ->route('vendas.index')
            ->with('success', 'Venda atualizada com sucesso!');
    }

    public function destroy(Venda $venda)
    {
        $venda->itensVenda()->delete();
        $venda->pagamento()->delete();
        $venda->delete();

        return redirect()
            ->route('vendas.index')
            ->with('success', 'Venda removida com sucesso!');
    }
}