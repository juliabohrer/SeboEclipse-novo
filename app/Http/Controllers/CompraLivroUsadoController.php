<?php

namespace App\Http\Controllers;

use App\Models\CompraLivroUsado;
use App\Models\CompraLivroUsadoItem;
use App\Models\Usuario;
use App\Models\Livro;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class CompraLivroUsadoController extends Controller
{
    public function index()
    {
        $compras = CompraLivroUsado::with(['usuario', 'itens'])->get();

        return view('compras.list', compact('compras'));
    }

    public function search(Request $request)
    {
        $search = trim($request->input('search', ''));

        $query = CompraLivroUsado::with(['usuario', 'itens']);

        if ($search) {
            foreach (explode(' ', $search) as $palavra) {
                if ($palavra === '') continue;
                $query->where(function ($q) use ($palavra) {
                    $q->whereHas('usuario', function ($u) use ($palavra) {
                        $u->where('nome', 'like', "%{$palavra}%");
                    })
                    ->orWhere('fornecedor', 'like', "%{$palavra}%")
                    ->orWhereHas('itens', function ($i) use ($palavra) {
                        $i->where('titulo', 'like', "%{$palavra}%")
                          ->orWhere('autor', 'like', "%{$palavra}%");
                    });
                });
            }
        }

        $compras = $query->get();

        return view('compras.list', compact('compras'));
    }

    public function create()
    {
        $usuarios = Usuario::all();

        return view('compras.form', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'usuario_id'                 => 'required|exists:usuarios,id',
            'fornecedor'                 => 'nullable|string|max:255',
            'data'                       => 'required|date',
            'itens'                      => 'required|array|min:1',
            'itens.*.titulo'             => 'required|string|max:255',
            'itens.*.autor'              => 'required|string|max:255',
            'itens.*.genero'             => 'required|string|max:255',
            'itens.*.editora'            => 'required|string|max:255',
            'itens.*.estado_conservacao' => 'required|string|max:255',
            'itens.*.preco_venda'        => 'required|numeric|min:0',
            'itens.*.valor_pago'         => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $compra = CompraLivroUsado::create([
                'usuario_id'  => $request->usuario_id,
                'fornecedor'  => $request->fornecedor,
                'data'        => $request->data,
                'valor_total' => collect($request->itens)->sum('valor_pago'),
            ]);

            foreach ($request->itens as $item) {
                $livro = Livro::create([
                    'titulo'             => $item['titulo'],
                    'autor'              => $item['autor'],
                    'genero'             => $item['genero'],
                    'editora'            => $item['editora'],
                    'preco'              => $item['preco_venda'],
                    'estado_conservacao' => $item['estado_conservacao'],
                    'disponivel'         => true,
                ]);

                CompraLivroUsadoItem::create([
                    'compra_id'          => $compra->id,
                    'livro_id'           => $livro->id,
                    'titulo'             => $item['titulo'],
                    'autor'              => $item['autor'],
                    'genero'             => $item['genero'],
                    'editora'            => $item['editora'],
                    'estado_conservacao' => $item['estado_conservacao'],
                    'preco_venda'        => $item['preco_venda'],
                    'valor_pago'         => $item['valor_pago'],
                ]);
            }
        });

        return redirect()
            ->route('compras.index')
            ->with('success', 'Compra registrada e livros adicionados ao acervo!');
    }

    public function edit(CompraLivroUsado $compra)
    {
        $usuarios = Usuario::all();
        $compra->load('itens');

        return view('compras.form', compact('compra', 'usuarios'));
    }

    public function update(Request $request, CompraLivroUsado $compra)
    {
        $request->validate([
            'usuario_id'                 => 'required|exists:usuarios,id',
            'fornecedor'                 => 'nullable|string|max:255',
            'data'                       => 'required|date',
            'itens'                      => 'required|array|min:1',
            'itens.*.titulo'             => 'required|string|max:255',
            'itens.*.autor'              => 'required|string|max:255',
            'itens.*.genero'             => 'required|string|max:255',
            'itens.*.editora'            => 'required|string|max:255',
            'itens.*.estado_conservacao' => 'required|string|max:255',
            'itens.*.preco_venda'        => 'required|numeric|min:0',
            'itens.*.valor_pago'         => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $compra) {
            $compra->update([
                'usuario_id'  => $request->usuario_id,
                'fornecedor'  => $request->fornecedor,
                'data'        => $request->data,
                'valor_total' => collect($request->itens)->sum('valor_pago'),
            ]);

            foreach ($compra->itens as $itemAntigo) {
                if ($itemAntigo->livro_id) {
                    Livro::find($itemAntigo->livro_id)?->delete();
                }
                $itemAntigo->delete();
            }

            foreach ($request->itens as $item) {
                $livro = Livro::create([
                    'titulo'             => $item['titulo'],
                    'autor'              => $item['autor'],
                    'genero'             => $item['genero'],
                    'editora'            => $item['editora'],
                    'preco'              => $item['preco_venda'],
                    'estado_conservacao' => $item['estado_conservacao'],
                    'disponivel'         => true,
                ]);

                CompraLivroUsadoItem::create([
                    'compra_id'          => $compra->id,
                    'livro_id'           => $livro->id,
                    'titulo'             => $item['titulo'],
                    'autor'              => $item['autor'],
                    'genero'             => $item['genero'],
                    'editora'            => $item['editora'],
                    'estado_conservacao' => $item['estado_conservacao'],
                    'preco_venda'        => $item['preco_venda'],
                    'valor_pago'         => $item['valor_pago'],
                ]);
            }
        });

        return redirect()
            ->route('compras.index')
            ->with('success', 'Compra atualizada com sucesso!');
    }

    public function destroy(CompraLivroUsado $compra)
    {
        DB::transaction(function () use ($compra) {
            foreach ($compra->itens as $item) {
                if ($item->livro_id) {
                    Livro::find($item->livro_id)?->delete();
                }
            }
            $compra->delete();
        });

        return redirect()
            ->route('compras.index')
            ->with('success', 'Compra e livros removidos com sucesso!');
    }
}