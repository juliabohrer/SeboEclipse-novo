<?php

namespace App\Http\Controllers;

use App\Models\InscricaoEvento;
use App\Models\Usuario;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller;

class InscricaoEventoController extends Controller
{
    public function index()
    {
        $inscricoes = InscricaoEvento::with(['usuario', 'evento'])->get();
        return view('inscricoes.list', compact('inscricoes'));
    }

    public function create(Request $request)
    {
        $usuarios = Usuario::all();
        $eventos = Evento::all();
        $eventoSelecionado = $request->evento_id;
        return view('inscricoes.form', compact('usuarios', 'eventos', 'eventoSelecionado'));
    }

    public function store(Request $request)
    {
        $isCliente = auth()->check() && auth()->user()->tipo === 'cliente';

        if ($isCliente) {
            $request->merge(['usuario_id' => auth()->user()->id]);
        }

        $validated = $request->validate([
            'usuario_id'      => 'required|exists:usuarios,id',
            'evento_id'       => 'required|exists:eventos,id',
            'data_inscricao'  => 'required|date',
            'forma_pagamento' => 'required|in:pix,cartao_credito,cartao_debito,dinheiro',
        ]);

        $evento = Evento::with('inscricoes')->findOrFail($validated['evento_id']);

        if ($evento->inscricoes->count() >= $evento->limite_pessoas) {
            return back()->withErrors(['evento_id' => 'Este evento está lotado.'])->withInput();
        }

        $jaInscrito = InscricaoEvento::where('usuario_id', $validated['usuario_id'])
            ->where('evento_id', $validated['evento_id'])
            ->exists();

        if ($jaInscrito) {
            return back()->withErrors(['usuario_id' => 'Você já está inscrito neste evento.'])->withInput();
        }

        $validated['codigo_inscricao'] = strtoupper(Str::random(8));

        InscricaoEvento::create($validated);

        if ($isCliente) {
            return redirect()->route('cliente.eventos')
                             ->with('success', 'Inscrição realizada com sucesso!');
        }

        return redirect()->route('inscricoes.index')
                         ->with('success', 'Inscrição realizada com sucesso!');
    }

    public function edit(InscricaoEvento $inscricao)
    {
        $usuarios = Usuario::all();
        $eventos = Evento::all();
        return view('inscricoes.form', compact('inscricao', 'usuarios', 'eventos'));
    }

    public function update(Request $request, InscricaoEvento $inscricao)
    {
        $validated = $request->validate([
            'usuario_id'      => 'required|exists:usuarios,id',
            'evento_id'       => 'required|exists:eventos,id',
            'data_inscricao'  => 'required|date',
            'forma_pagamento' => 'required|in:pix,cartao_credito,cartao_debito,dinheiro',
        ]);

        $inscricao->update($validated);

        return redirect()->route('inscricoes.index')
                         ->with('success', 'Inscrição atualizada com sucesso!');
    }

    public function destroy(InscricaoEvento $inscricao)
    {
        $inscricao->delete();

        return redirect()->route('inscricoes.index')
                         ->with('success', 'Inscrição removida com sucesso!');
    }

    public function porEvento(Evento $evento)
    {
        $inscricoes = $evento->inscricoes()->with('usuario')->get();
        return view('inscricoes.list', compact('inscricoes', 'evento'));
    }

    public function createCliente(Evento $evento)
    {
        return view('inscricoes.form', compact('evento'));
    }
}