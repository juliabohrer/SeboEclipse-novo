<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Controller;  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'senha' => 'required',
        ]);

        // Busca o usuário pelo email
        $usuario = Usuario::where('email', $request->email)->first();

        // Verifica se existe e se a senha bate
        if (!$usuario || !Hash::check($request->senha, $usuario->senha)) {
            return back()->withErrors([
                'email' => 'E-mail ou senha incorretos.',
            ]);
        }

        Auth::login($usuario);
        $request->session()->regenerate();

        if ($usuario->tipo === 'adm') {
            return redirect()->route('livros.index');
        }

        return redirect()->route('cliente.home');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}