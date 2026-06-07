<?php

namespace App\Http\Controllers;

use App\Models\TrocaLivro;
use App\Models\Livro;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TrocaLivroController extends Controller
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
        $trocas = TrocaLivro::with(['livroNovo', 'livroAntigo', 'usuario'])->get();
        return view('troca-livros.list', compact('trocas'));
    }

    public function create()
{
    $livrosDisponiveis = Livro::where('disponivel', true)->get();  // livros do acervo para dar
    $livrosCliente     = Livro::where('disponivel', false)->get(); // livros que clientes podem entregar
    $usuarios          = Usuario::all();

    return view('troca-livros.form', compact('livrosDisponiveis', 'livrosCliente', 'usuarios'));
}

   public function store(Request $request)
{
    $validated = $request->validate([
        'livro_novo_id'       => 'required|exists:livros,id',
        'livro_antigo_titulo' => 'required|string|max:255',
        'livro_antigo_autor'  => 'required|string|max:255',
        'usuario_id'          => 'required|exists:usuarios,id',
        'valor_pago'          => 'required|numeric|min:0',
        'status'              => 'required|in:pendente,aprovada,recusada,concluida',
    ]);

    // Cria o livro antigo no acervo automaticamente
    $livroAntigo = Livro::create([
        'titulo'             => $validated['livro_antigo_titulo'],
        'autor'              => $validated['livro_antigo_autor'],
        'editora'            => 'Desconhecida',
        'disponivel'         => true,
        'preco'              => 0,
        'genero'             => 'A definir',
        'estado_conservacao' => 'usado',
    ]);

    TrocaLivro::create([
        'livro_novo_id'   => $validated['livro_novo_id'],
        'livro_antigo_id' => $livroAntigo->id,
        'usuario_id'      => $validated['usuario_id'],
        'valor_pago'      => $validated['valor_pago'],
        'status'          => $validated['status'],
    ]);

    // Livro do acervo sai de circulação
    Livro::where('id', $validated['livro_novo_id'])->update(['disponivel' => false]);

    return redirect()->route('troca-livros.index')
                     ->with('success', 'Troca registrada com sucesso!');
}

    public function edit(TrocaLivro $trocaLivro)
    {
        $livros   = Livro::all();
        $usuarios = Usuario::all();
        return view('troca-livros.form', compact('trocaLivro', 'livros', 'usuarios'));
    }

    public function update(Request $request, TrocaLivro $trocaLivro)
{
    $validated = $request->validate([
        'livro_novo_id'       => 'required|exists:livros,id',
        'livro_antigo_titulo' => 'required|string|max:255',
        'livro_antigo_autor'  => 'required|string|max:255',
        'usuario_id'          => 'required|exists:usuarios,id',
        'valor_pago'          => 'required|numeric|min:0',
        'status'              => 'required|in:pendente,aprovada,recusada,concluida',
    ]);

    // Atualiza o livro antigo já cadastrado
    Livro::where('id', $trocaLivro->livro_antigo_id)->update([
        'titulo' => $validated['livro_antigo_titulo'],
        'autor'  => $validated['livro_antigo_autor'],
    ]);

    // Se trocou o livro novo, libera o anterior e bloqueia o novo
    if ($trocaLivro->livro_novo_id !== (int) $validated['livro_novo_id']) {
        Livro::where('id', $trocaLivro->livro_novo_id)->update(['disponivel' => true]);
        Livro::where('id', $validated['livro_novo_id'])->update(['disponivel' => false]);
    }

    // Se concluída ou recusada, libera o livro do acervo
    if (in_array($validated['status'], ['concluida', 'recusada'])) {
        Livro::where('id', $validated['livro_novo_id'])->update(['disponivel' => true]);
    }

    $trocaLivro->update([
        'livro_novo_id' => $validated['livro_novo_id'],
        'usuario_id'    => $validated['usuario_id'],
        'valor_pago'    => $validated['valor_pago'],
        'status'        => $validated['status'],
    ]);

    return redirect()->route('troca-livros.index')
                     ->with('success', 'Troca atualizada com sucesso!');
}
    public function destroy(TrocaLivro $trocaLivro)
{
    // Ao deletar a troca, libera o livro novamente
    Livro::where('id', $trocaLivro->livro_novo_id)
         ->update(['disponivel' => true]);

    $trocaLivro->delete();

    return redirect()->route('troca-livros.index')
                     ->with('success', 'Troca removida com sucesso!');
}
}