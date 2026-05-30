<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::all();

        return view('usuarios.list', compact('usuarios'));
    }

    public function create()
    {
        return view('usuarios.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome'            => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'cpf'             => 'required|string|unique:usuarios,cpf',
            'endereco'        => 'required|string|max:255',
            'telefone'        => 'required|string|max:20',
            'email'           => 'required|email|unique:usuarios,email',
            'senha'           => 'required|string|min:6|confirmed',
            'tipo'            => 'required|in:admin,cliente',
        ]);

        $validated['senha'] = Hash::make($validated['senha']);

        Usuario::create($validated);

        return redirect()->route('usuarios.index')
                         ->with('success', 'Usuário cadastrado com sucesso!');
    }

    public function edit(Usuario $usuario)
    {
        return view('usuarios.form', compact('usuario'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        $validated = $request->validate([
            'nome'            => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'cpf'             => 'required|string|unique:usuarios,cpf,' . $usuario->id,
            'endereco'        => 'required|string|max:255',
            'telefone'        => 'required|string|max:20',
            'email'           => 'required|email|unique:usuarios,email,' . $usuario->id,
            'senha'           => 'nullable|string|min:6|confirmed',
            'tipo'            => 'required|in:admin,cliente',
        ]);

        if (!empty($validated['senha'])) {
            $validated['senha'] = Hash::make($validated['senha']);
        } else {
            unset($validated['senha']);
        }

        $usuario->update($validated);

        return redirect()->route('usuarios.index')
                         ->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy(Usuario $usuario)
    {
        $usuario->delete();

        return redirect()->route('usuarios.index')
                         ->with('success', 'Usuário removido com sucesso!');
    }
}

