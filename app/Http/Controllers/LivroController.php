<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class LivroController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (in_array($request->route()->getActionMethod(), ['create', 'store', 'edit', 'update', 'destroy'])) {
                abort_if(auth()->user()->tipo !== 'adm', 403);
            }
            return $next($request);
        });
    }

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
            'editora'            => 'nullable|string|max:255',
            'imagem'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'preco'              => 'required|numeric|min:0',
            'estado_conservacao' => 'required|string|max:255',
            'disponivel'         => 'boolean',
        ], [
            'titulo.required'             => 'O título é obrigatório.',
            'autor.required'              => 'O autor é obrigatório.',
            'genero.required'             => 'O gênero é obrigatório.',
            'preco.required'              => 'O preço é obrigatório.',
            'estado_conservacao.required' => 'O estado de conservação é obrigatório.',
        ]);

        if ($request->hasFile('imagem')) {
            $validated['imagem'] = $request->file('imagem')->store('livros', 'public');
        }

        $validated['disponivel'] = $request->boolean('disponivel');

        Livro::create($validated);

        return redirect()
            ->route('livros.index')
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
            'editora'            => 'nullable|string|max:255',
            'imagem'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'preco'              => 'required|numeric|min:0',
            'estado_conservacao' => 'required|string|max:255',
            'disponivel'         => 'boolean',
        ], [
            'titulo.required'             => 'O título é obrigatório.',
            'autor.required'              => 'O autor é obrigatório.',
            'genero.required'             => 'O gênero é obrigatório.',
            'preco.required'              => 'O preço é obrigatório.',
            'estado_conservacao.required' => 'O estado de conservação é obrigatório.',
        ]);

        if ($request->hasFile('imagem')) {
            if ($livro->imagem && Storage::disk('public')->exists($livro->imagem)) {
                Storage::disk('public')->delete($livro->imagem);
            }
            $validated['imagem'] = $request->file('imagem')->store('livros', 'public');
        }

        $validated['disponivel'] = $request->boolean('disponivel');

        $livro->update($validated);

        return redirect()
            ->route('livros.index')
            ->with('success', 'Livro atualizado com sucesso!');
    }

    public function search(Request $request)
{
    $search = trim($request->input('search', ''));

    $query = Livro::query();

    if ($search) {
        foreach (explode(' ', $search) as $palavra) {
            if ($palavra === '') continue;
            $query->where(function ($q) use ($palavra) {
                $q->where('titulo', 'like', "%{$palavra}%")
                  ->orWhere('autor', 'like', "%{$palavra}%");
            });
        }
    }

    $livros = $query->get();

    return view('livros.list', compact('livros'));
}

    public function destroy(Livro $livro)
    {
        if ($livro->imagem && Storage::disk('public')->exists($livro->imagem)) {
            Storage::disk('public')->delete($livro->imagem);
        }

        $livro->delete();

        return redirect()
            ->route('livros.index')
            ->with('success', 'Livro removido com sucesso!');
    }
}