<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class LivroController extends Controller
{
    public function index()
    {
        $livros = Livro::all();

        return view('livros.list', compact('livros'));
    }

    public function create()
    {
        return view('livros.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo'             => 'required|string|max:255',
            'autor'              => 'required|string|max:255',
            'genero'             => 'required|string|max:255',
            'editora'            => 'required|string|max:255',
            'preco'              => 'required|numeric|min:0',
            'estado_conservacao' => 'required|string|max:255',
            'disponivel'         => 'boolean',
        ]);

        Livro::create($validated);

        return redirect()->route('livros.index')
                         ->with('success', 'Livro cadastrado com sucesso!');
    }

    public function edit(Livro $livro)
    {
        return view('livros.form', compact('livro'));
    }

    public function update(Request $request, Livro $livro)
    {
        $validated = $request->validate([
            'titulo'             => 'required|string|max:255',
            'autor'              => 'required|string|max:255',
            'genero'             => 'required|string|max:255',
            'editora'            => 'required|string|max:255',
            'preco'              => 'required|numeric|min:0',
            'estado_conservacao' => 'required|string|max:255',
            'disponivel'         => 'boolean',
        ]);

        $livro->update($validated);

        return redirect()->route('livros.index')
                         ->with('success', 'Livro atualizado com sucesso!');
    }

    public function destroy(Livro $livro)
    {
        $livro->delete();

        return redirect()->route('livros.index')
                         ->with('success', 'Livro removido com sucesso!');
    }
}
