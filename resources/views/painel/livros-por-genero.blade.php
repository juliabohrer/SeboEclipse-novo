@extends('main')

@section('titulo', 'Livros por Gênero · Painel · Eclipse Sebo')

@section('content')

<div class="top-bar">
    <div class="heading">
        <p class="tag">Painel</p>
        <h1>Livros por Gênero</h1>
        <p class="subtitle">Distribuição do estoque por gênero literário</p>
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
        <p class="painel-resumo-card__label">Total de livros</p>
        <p class="painel-resumo-card__valor painel-resumo-card__valor--purple">{{ $totalLivros }}</p>
    </div>
    <div class="painel-resumo-card">
        <p class="painel-resumo-card__label">Gêneros diferentes</p>
        <p class="painel-resumo-card__valor painel-resumo-card__valor--gold">{{ $totalGeneros }}</p>
    </div>
    @if ($generoPrincipal)
    <div class="painel-resumo-card">
        <p class="painel-resumo-card__label">Gênero mais popular</p>
        <p class="painel-resumo-card__valor painel-resumo-card__valor--green" style="font-size:1.1rem">{{ $generoPrincipal->genero }}</p>
    </div>
    @endif
</div>

{{-- Gráfico --}}
<div class="card">
    <div class="card-body">
        <p class="painel-card__titulo">Estoque por Gênero</p>
        <p class="painel-card__subtitulo">Quantidade de livros por gênero literário</p>
        <div class="painel-card__chart painel-card__chart--pizza">
            <canvas id="graficoPizza"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const labelsGeneros = @json($labelsGeneros);
    const dadosGeneros  = @json($dadosGeneros);

    const cores = [
        'rgba(167,139,250,0.85)', 'rgba(226,184,90,0.85)',
        'rgba(110,231,183,0.85)', 'rgba(248,113,113,0.85)',
        'rgba(251,146,60,0.85)',  'rgba(96,165,250,0.85)',
        'rgba(244,114,182,0.85)', 'rgba(167,243,208,0.85)',
        'rgba(253,224,71,0.85)',  'rgba(196,181,253,0.85)',
    ];

    Chart.defaults.color       = '#7c7a9e';
    Chart.defaults.font.family = "'Crimson Pro', Georgia, serif";
    Chart.defaults.font.size   = 13;

    new Chart(document.getElementById('graficoPizza'), {
        type: 'doughnut',
        data: {
            labels: labelsGeneros,
            datasets: [{
                data:            dadosGeneros,
                backgroundColor: cores,
                borderColor:     cores.map(c => c.replace('0.85', '1')),
                borderWidth: 1,
                hoverOffset: 8,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { color: '#b0adc8', padding: 16, boxWidth: 12, boxHeight: 12 },
                },
                tooltip: {
                    backgroundColor: '#1a1830',
                    borderColor:     'rgba(180,160,255,.2)',
                    borderWidth: 1,
                    titleColor: '#e8e6f5',
                    bodyColor:  '#b0adc8',
                    callbacks: {
                        label: ctx => ` ${ctx.label}: ${ctx.parsed} livros`,
                    },
                },
            },
        },
    });
});
</script>

@endsection