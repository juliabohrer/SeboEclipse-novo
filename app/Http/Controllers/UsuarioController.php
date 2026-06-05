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
        $isPublico = !auth()->check() || auth()->user()->tipo !== 'adm';

        $validated = $request->validate([
            'nome'            => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'cpf'             => 'required|string|unique:usuarios,cpf',
            'endereco'        => 'required|string|max:255',
            'telefone'        => 'required|string|max:20',
            'email'           => 'required|email|unique:usuarios,email',
            'senha'           => 'required|string|min:6|confirmed',
            'tipo'            => $isPublico ? 'nullable' : 'required|in:adm,cliente',
        ]);

        $validated['senha'] = Hash::make($validated['senha']);

        if ($isPublico) {
            $validated['tipo'] = 'cliente';
        }

        Usuario::create($validated);

        if ($isPublico) {
            return redirect()->route('login')
                             ->with('success', 'Conta criada com sucesso! Faça login.');
        }

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
            'tipo'            => 'required|in:adm,cliente',
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

    // ── CLIENTE: editar o próprio perfil ──────────────────────────────────────

    public function editPerfil()
    {
        $usuario = auth()->user();
        return view('usuarios.form', compact('usuario'));
    }

    public function updatePerfil(Request $request)
    {
        $usuario = auth()->user();

        $validated = $request->validate([
            'nome'            => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'cpf'             => 'required|string|unique:usuarios,cpf,' . $usuario->id,
            'endereco'        => 'required|string|max:255',
            'telefone'        => 'required|string|max:20',
            'email'           => 'required|email|unique:usuarios,email,' . $usuario->id,
            'senha'           => 'nullable|string|min:6|confirmed',
        ]);

        if (!empty($validated['senha'])) {
            $validated['senha'] = Hash::make($validated['senha']);
        } else {
            unset($validated['senha']);
        }

        $usuario->update($validated);

        return redirect()->route('cliente.perfil')
                         ->with('success', 'Perfil atualizado com sucesso!');
    }

    public function destroy(Usuario $usuario)
    {
        $usuario->delete();

        return redirect()->route('usuarios.index')
                         ->with('success', 'Usuário removido com sucesso!');
    }
}
