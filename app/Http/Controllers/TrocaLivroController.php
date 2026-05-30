<?php

namespace App\Http\Controllers;

use App\Models\TrocaLivro;
use App\Models\Livro;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TrocaLivroController extends Controller
{
    public function index()
    {
        $trocas = TrocaLivro::with([
            'livroNovo',
            'livroAntigo',
            'usuario'
        ])->get();

        return view('troca-livros.list', compact('trocas'));
    }

    public function create()
    {
        $livros = Livro::where('disponivel', true)->get();

        $usuarios = Usuario::all();

        return view(
            'troca-livros.form',
            compact('livros', 'usuarios')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'livro_novo_id'   => 'required|exists:livros,id|different:livro_antigo_id',
            'livro_antigo_id' => 'required|exists:livros,id',
            'usuario_id'      => 'required|exists:usuarios,id',
            'valor_pago'      => 'required|numeric|min:0',
            'disponivel'      => 'boolean',
            'status'          => 'required|in:pendente,aprovada,recusada,concluida',
        ]);

        TrocaLivro::create($validated);

        return redirect()
            ->route('troca-livros.index')
            ->with('success', 'Troca registrada com sucesso!');
    }

    public function edit(TrocaLivro $trocaLivro)
    {
        $livros = Livro::all();

        $usuarios = Usuario::all();

        return view(
            'troca-livros.form',
            compact('trocaLivro', 'livros', 'usuarios')
        );
    }

    public function update(Request $request, TrocaLivro $trocaLivro)
    {
        $validated = $request->validate([
            'livro_novo_id'   => 'required|exists:livros,id|different:livro_antigo_id',
            'livro_antigo_id' => 'required|exists:livros,id',
            'usuario_id'      => 'required|exists:usuarios,id',
            'valor_pago'      => 'required|numeric|min:0',
            'disponivel'      => 'boolean',
            'status'          => 'required|in:pendente,aprovada,recusada,concluida',
        ]);

        $trocaLivro->update($validated);

        return redirect()
            ->route('troca-livros.index')
            ->with('success', 'Troca atualizada com sucesso!');
    }

    public function destroy(TrocaLivro $trocaLivro)
    {
        $trocaLivro->delete();

        return redirect()
            ->route('troca-livros.index')
            ->with('success', 'Troca removida com sucesso!');
    }
}
