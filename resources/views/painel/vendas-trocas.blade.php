@extends('main')

@section('titulo', 'Vendas e Trocas · Painel · Eclipse Sebo')

@section('content')

<div class="top-bar">
    <div class="heading">
        <p class="tag">Painel</p>
        <h1>Vendas e Trocas</h1>
        <p class="subtitle">Comparativo mensal dos últimos 6 meses</p>
    </div>
    <a href="{{ route('painel.index') }}" class="btn btn-ghost">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"/>
            <polyline points="12 19 5 12 12 5"/>
        </svg>
        Voltar ao Painel
    </a>
</div>

{{-- Cards resumo --}}
<div class="painel-resumo-grid">
    <div class="painel-resumo-card">
        <p class="painel-resumo-card__label">Vendas este mês</p>
        <p class="painel-resumo-card__valor painel-resumo-card__valor--purple">{{ $totalVendasMes }}</p>
    </div>
    <div class="painel-resumo-card">
        <p class="painel-resumo-card__label">Trocas este mês</p>
        <p class="painel-resumo-card__valor painel-resumo-card__valor--gold">{{ $totalTrocasMes }}</p>
    </div>
</div>

{{-- Gráfico --}}
<div class="card">
    <div class="card-body">
        <p class="painel-card__titulo">Vendas e Trocas — Últimos 6 Meses</p>
        <p class="painel-card__subtitulo">Quantidade de operações por mês</p>
        <div class="painel-card__chart">
            <canvas id="graficoBarras"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const labelsMeses  = @json($labelsMeses);
    const dadosVendas  = @json($dadosVendas);
    const dadosTrocas  = @json($dadosTrocas);

    Chart.defaults.color       = '#7c7a9e';
    Chart.defaults.font.family = "'Crimson Pro', Georgia, serif";
    Chart.defaults.font.size   = 13;

    new Chart(document.getElementById('graficoBarras'), {
        type: 'bar',
        data: {
            labels: labelsMeses,
            datasets: [
                {
                    label: 'Vendas',
                    data: dadosVendas,
                    backgroundColor: 'rgba(167,139,250,0.85)',
                    borderColor:     'rgba(167,139,250,1)',
                    borderWidth: 1,
                    borderRadius: 6,
                    borderSkipped: false,
                },
                {
                    label: 'Trocas',
                    data: dadosTrocas,
                    backgroundColor: 'rgba(226,184,90,0.85)',
                    borderColor:     'rgba(226,184,90,1)',
                    borderWidth: 1,
                    borderRadius: 6,
                    borderSkipped: false,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    labels: { color: '#b0adc8', padding: 20 },
                },
                tooltip: {
                    backgroundColor: '#1a1830',
                    borderColor:     'rgba(180,160,255,.2)',
                    borderWidth: 1,
                    titleColor: '#e8e6f5',
                    bodyColor:  '#b0adc8',
                },
            },
            scales: {
                x: {
                    ticks: { color: '#7c7a9e' },
                    grid:  { color: 'rgba(180,160,255,0.1)' },
                },
                y: {
                    beginAtZero: true,
                    ticks: { color: '#7c7a9e', stepSize: 1, precision: 0 },
                    grid:  { color: 'rgba(180,160,255,0.1)' },
                },
            },
        },
    });
});
</script>

@endsection