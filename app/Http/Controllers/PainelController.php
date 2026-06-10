<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use App\Models\TrocaLivro;
use App\Models\Venda;
use App\Models\Compra;
use App\Models\Evento;
use App\Models\InscricaoEvento;
use App\Models\ItemVenda;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;

class PainelController extends Controller
{
    public function index()
    {
        return view('painel.index');
    }

    public function comprasTrocas()
    {
        $meses = collect(range(5, 0))->map(fn($i) => now()->subMonths($i)->format('Y-m'));

        $vendasPorMes = Venda::select(
                DB::raw("DATE_FORMAT(data_venda, '%Y-%m') as mes"),
                DB::raw('COUNT(*) as total')
            )
            ->where('data_venda', '>=', now()->subMonths(6)->startOfMonth())
            ->groupBy('mes')
            ->pluck('total', 'mes');

        $trocasPorMes = TrocaLivro::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as mes"),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(6)->startOfMonth())
            ->groupBy('mes')
            ->pluck('total', 'mes');

        $labelsMeses = $meses->map(fn($m) =>
            \Carbon\Carbon::createFromFormat('Y-m', $m)->locale('pt_BR')->isoFormat('MMM/YY')
        )->values();

        $dadosVendas = $meses->map(fn($m) => $vendasPorMes[$m] ?? 0)->values();
        $dadosTrocas = $meses->map(fn($m) => $trocasPorMes[$m] ?? 0)->values();

        $mesAtual       = now()->format('Y-m');
        $totalVendasMes = $vendasPorMes[$mesAtual] ?? 0;
        $totalTrocasMes = $trocasPorMes[$mesAtual] ?? 0;

        return view('painel.vendas-trocas', compact(
            'labelsMeses', 'dadosVendas', 'dadosTrocas',
            'totalVendasMes', 'totalTrocasMes'
        ));
    }

    public function livrosPorGenero()
    {
        $livrosPorGenero = Livro::select('genero', DB::raw('COUNT(*) as total'))
            ->groupBy('genero')
            ->orderByDesc('total')
            ->get();

        $labelsGeneros   = $livrosPorGenero->pluck('genero');
        $dadosGeneros    = $livrosPorGenero->pluck('total');
        $totalLivros     = $livrosPorGenero->sum('total');
        $totalGeneros    = $livrosPorGenero->count();
        $generoPrincipal = $livrosPorGenero->first();

        return view('painel.livros-por-genero', compact(
            'labelsGeneros', 'dadosGeneros',
            'totalLivros', 'totalGeneros', 'generoPrincipal'
        ));
    }

    public function relatorioPdf()
    {
        $totalCompras = Compra::sum('valor_total');
        $totalVendas  = Venda::sum('valor_total');
        $totalTrocas  = TrocaLivro::sum('valor_pago');
        $lucroBruto   = ($totalVendas + $totalTrocas) - $totalCompras;

        $comprados = Compra::count(); // ← corrigido
        $vendidos  = ItemVenda::sum('quantidade');
        $trocados  = TrocaLivro::count();

        $disponiveis   = Livro::where('disponivel', true)->count();
        $indisponiveis = Livro::where('disponivel', false)->count();
        $totalLivros   = Livro::count();

        $pdf = Pdf::loadView('painel.relatorio-pdf', compact(
            'totalCompras', 'totalVendas', 'totalTrocas', 'lucroBruto',
            'comprados', 'vendidos', 'trocados',
            'disponiveis', 'indisponiveis', 'totalLivros'
        ));

        return $pdf->download('Relatorio-Eclipse-Sebo.pdf');
    }

    public function relatorioEventosPdf()
    {
        $mesInicio = now()->startOfMonth();
        $mesFim    = now()->endOfMonth();

        $eventosMes = Evento::with(['inscricoes.usuario'])
            ->whereBetween('data_hora_inicio', [$mesInicio, $mesFim])
            ->get();

        $totalInscricoesMes = InscricaoEvento::whereBetween('data_inscricao', [$mesInicio, $mesFim])
            ->count();

        $receitaMes = InscricaoEvento::whereBetween('data_inscricao', [$mesInicio, $mesFim])
            ->with('evento')
            ->get()
            ->sum(fn($i) => $i->evento?->valor_ingresso ?? 0);

        $eventoMaisPopular = $eventosMes->sortByDesc(fn($e) => $e->inscricoes->count())->first();

        $pdf = Pdf::loadView('painel.relatorio-eventos-pdf', compact(
            'eventosMes',
            'totalInscricoesMes',
            'receitaMes',
            'eventoMaisPopular'
        ));

        return $pdf->download('Relatorio-Eventos-' . now()->format('m-Y') . '.pdf');
    }
}