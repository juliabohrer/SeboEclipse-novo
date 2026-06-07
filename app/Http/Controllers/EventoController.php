<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class EventoController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (in_array(
                $request->route()->getActionMethod(),
                ['create', 'store', 'edit', 'update', 'destroy']
            )) {
                abort_if(auth()->user()->tipo !== 'adm', 403);
            }
            return $next($request);
        });
    }

    public function index()
    {
        $eventos = Evento::with(['usuario', 'inscricoes.usuario'])->get();

        return view('eventos.list', compact('eventos'));
    }

    public function search(Request $request)
    {
        $search = trim($request->input('search', ''));

        $query = Evento::with(['usuario', 'inscricoes.usuario']);

        if ($search) {
            foreach (explode(' ', $search) as $palavra) {
                if ($palavra === '') continue;
                $query->where(function ($q) use ($palavra) {
                    $q->where('titulo', 'like', "%{$palavra}%")
                      ->orWhereHas('usuario', function ($u) use ($palavra) {
                          $u->where('nome', 'like', "%{$palavra}%");
                      });
                });
            }
        }

        $eventos = $query->get();

        return view('eventos.list', compact('eventos'));
    }

    public function create()
    {
        $usuarios = Usuario::all();

        return view('eventos.form', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'usuario_id'       => 'required|exists:usuarios,id',
            'titulo'           => 'required|string|max:255',
            'descricao'        => 'required|string',
            'imagem'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'data_hora_inicio' => 'required|date',
            'data_hora_fim'    => 'required|date|after:data_hora_inicio',
            'limite_pessoas'   => 'required|integer|min:1',
            'valor_ingresso'   => 'required|numeric|min:0',
        ], [
            'usuario_id.required'       => 'Selecione um organizador.',
            'titulo.required'           => 'O título é obrigatório.',
            'descricao.required'        => 'A descrição é obrigatória.',
            'data_hora_inicio.required' => 'A data de início é obrigatória.',
            'data_hora_fim.required'    => 'A data de término é obrigatória.',
            'limite_pessoas.required'   => 'O limite de pessoas é obrigatório.',
            'valor_ingresso.required'   => 'O valor do ingresso é obrigatório.',
        ]);

        if ($request->hasFile('imagem')) {
            $validated['imagem'] = $request->file('imagem')->store('eventos', 'public');
        }

        Evento::create($validated);

        return redirect()
            ->route('eventos.index')
            ->with('success', 'Evento criado com sucesso!');
    }

    public function edit(Evento $evento)
    {
        $usuarios = Usuario::all();

        return view('eventos.form', compact('evento', 'usuarios'));
    }

    public function update(Request $request, Evento $evento)
    {
        $validated = $request->validate([
            'usuario_id'       => 'required|exists:usuarios,id',
            'titulo'           => 'required|string|max:255',
            'descricao'        => 'required|string',
            'imagem'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'data_hora_inicio' => 'required|date',
            'data_hora_fim'    => 'required|date|after:data_hora_inicio',
            'limite_pessoas'   => 'required|integer|min:1',
            'valor_ingresso'   => 'required|numeric|min:0',
        ], [
            'usuario_id.required'       => 'Selecione um organizador.',
            'titulo.required'           => 'O título é obrigatório.',
            'descricao.required'        => 'A descrição é obrigatória.',
            'data_hora_inicio.required' => 'A data de início é obrigatória.',
            'data_hora_fim.required'    => 'A data de término é obrigatória.',
            'limite_pessoas.required'   => 'O limite de pessoas é obrigatório.',
            'valor_ingresso.required'   => 'O valor do ingresso é obrigatório.',
        ]);

        if ($request->hasFile('imagem')) {
            if ($evento->imagem && Storage::disk('public')->exists($evento->imagem)) {
                Storage::disk('public')->delete($evento->imagem);
            }
            $validated['imagem'] = $request->file('imagem')->store('eventos', 'public');
        }

        $evento->update($validated);

        return redirect()
            ->route('eventos.index')
            ->with('success', 'Evento atualizado com sucesso!');
    }

    public function destroy(Evento $evento)
    {
        if ($evento->imagem && Storage::disk('public')->exists($evento->imagem)) {
            Storage::disk('public')->delete($evento->imagem);
        }

        $evento->delete();

        return redirect()
            ->route('eventos.index')
            ->with('success', 'Evento removido com sucesso!');
    }
    public function porEvento(Evento $evento)
{
    $inscricoes = $evento->inscricoes()->with('usuario')->get();
    return view('inscricoes.porEvento', compact('evento', 'inscricoes'));
}
}