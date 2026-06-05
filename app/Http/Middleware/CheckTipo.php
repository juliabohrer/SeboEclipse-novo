<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckTipo
{
    public function handle(Request $request, Closure $next, string $tipo)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // ADM tem acesso a tudo, nunca bloqueia
        if (auth()->user()->tipo === 'adm') {
            return $next($request);
        }

        // Outros tipos só passam se o tipo bater
        if (auth()->user()->tipo !== $tipo) {
            abort(403, 'Acesso não autorizado.');
        }

        return $next($request);
    }
}
