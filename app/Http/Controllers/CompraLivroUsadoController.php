<?php

namespace App\Http\Controllers;

use App\Models\CompraLivroUsado;
use App\Models\Usuario;
use App\Models\Livro;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CompraLivroUsadoController extends Controller
{
    public function index()
    {
        $compras = CompraLivroUsado::with([
            'usuario',
            'livro'
        ])->get();

        return view('compras.list', compact('compras'));
    }

    public function create()
    {
        $usuarios = Usuario::all();

        $livros = Livro::where(
            'disponivel',
            true
        )->get();

        return view(
            'compras.form',
            compact('usuarios', 'livros')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'livro_id'   => 'required|exists:livros,id',
            'data'       => 'required|date',
            'valor_pago' => 'required|numeric|min:0',
        ]);

        CompraLivroUsado::create($validated);

        Livro::find(
            $validated['livro_id']
        )->update([
            'disponivel' => false
        ]);

        return redirect()
            ->route('compras.index')
            ->with(
                'success',
                'Compra registrada com sucesso!'
            );
    }

    public function edit(CompraLivroUsado $compra)
    {
        $usuarios = Usuario::all();

        $livros = Livro::all();

        return view(
            'compras.form',
            compact(
                'compra',
                'usuarios',
                'livros'
            )
        );
    }

    public function update(
        Request $request,
        CompraLivroUsado $compra
    ) {
        $validated = $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'livro_id'   => 'required|exists:livros,id',
            'data'       => 'required|date',
            'valor_pago' => 'required|numeric|min:0',
        ]);

        $compra->update($validated);

        return redirect()
            ->route('compras.index')
            ->with(
                'success',
                'Compra atualizada com sucesso!'
            );
    }

    public function destroy(
        CompraLivroUsado $compra
    ) {
        Livro::find(
            $compra->livro_id
        )->update([
            'disponivel' => true
        ]);

        $compra->delete();

        return redirect()
            ->route('compras.index')
            ->with(
                'success',
                'Compra removida com sucesso!'
            );
    }
}
