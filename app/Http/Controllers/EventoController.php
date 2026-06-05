<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EventoController extends Controller
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
        $eventos = Evento::with(['usuario', 'inscricoes.usuario'])->get();
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
            'data_hora_inicio' => 'required|date',
            'data_hora_fim'    => 'required|date|after:data_hora_inicio',
            'limite_pessoas'   => 'required|integer|min:1',
            'valor_ingresso'   => 'required|numeric|min:0',
        ]);

        Evento::create($validated);

        return redirect()->route('eventos.index')
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
            'data_hora_inicio' => 'required|date',
            'data_hora_fim'    => 'required|date|after:data_hora_inicio',
            'limite_pessoas'   => 'required|integer|min:1',
            'valor_ingresso'   => 'required|numeric|min:0',
        ]);

        $evento->update($validated);

        return redirect()->route('eventos.index')
                         ->with('success', 'Evento atualizado com sucesso!');
    }

    public function destroy(Evento $evento)
    {
        $evento->delete();

        return redirect()->route('eventos.index')
                         ->with('success', 'Evento removido com sucesso!');
    }
}