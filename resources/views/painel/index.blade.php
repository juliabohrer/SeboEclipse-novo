@extends('main')

@section('titulo', 'Painel · Eclipse Sebo')

@section('content')

<div class="top-bar">
    <div class="heading">
        <p class="tag">Administração</p>
        <h1>Painel</h1>
        <p class="subtitle">Relatórios e visualizações do sistema</p>
    </div>
</div>

<div class="painel-nav-grid">

    <a href="{{ route('painel.vendas-trocas') }}" class="painel-nav-card">
        <div class="painel-nav-card__icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/>
                <polyline points="16 7 22 7 22 13"/>
            </svg>
        </div>
        <div class="painel-nav-card__content">
            <p class="painel-nav-card__titulo">Vendas e Trocas</p>
            <p class="painel-nav-card__desc">Comparativo mensal de vendas e trocas.</p>
        </div>
        <div class="painel-nav-card__arrow">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="5" y1="12" x2="19" y2="12"/>
                <polyline points="12 5 19 12 12 19"/>
            </svg>
        </div>
    </a>

    <a href="{{ route('painel.livros-por-genero') }}" class="painel-nav-card">
        <div class="painel-nav-card__icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M4 19.5A2.5 2.5 0 016.5 17H20"/>
                <path d="M4 4.5A2.5 2.5 0 016.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15z"/>
            </svg>
        </div>
        <div class="painel-nav-card__content">
            <p class="painel-nav-card__titulo">Livros por Gênero</p>
            <p class="painel-nav-card__desc">Distribuição do estoque por gênero literário.</p>
        </div>
        <div class="painel-nav-card__arrow">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="5" y1="12" x2="19" y2="12"/>
                <polyline points="12 5 19 12 12 19"/>
            </svg>
        </div>
    </a>

    <a href="{{ route('painel.relatorio.pdf') }}" class="painel-nav-card">
        <div class="painel-nav-card__icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M6 2h9l5 5v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z"/>
                <path d="M14 2v6h6"/>
                <line x1="8" y1="13" x2="16" y2="13"/>
                <line x1="8" y1="17" x2="16" y2="17"/>
            </svg>
        </div>
        <div class="painel-nav-card__content">
            <p class="painel-nav-card__titulo">Relatório Geral</p>
            <p class="painel-nav-card__desc">Gere um relatório completo do Eclipse Sebo em PDF.</p>
        </div>
        <div class="painel-nav-card__arrow">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="5" y1="12" x2="19" y2="12"/>
                <polyline points="12 5 19 12 12 19"/>
            </svg>
        </div>
    </a>

    <a href="{{ route('painel.relatorio.eventos.pdf') }}" class="painel-nav-card">
        <div class="painel-nav-card__icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
                <line x1="8" y1="14" x2="8" y2="14"/>
                <line x1="12" y1="14" x2="12" y2="14"/>
                <line x1="16" y1="14" x2="16" y2="14"/>
            </svg>
        </div>
        <div class="painel-nav-card__content">
            <p class="painel-nav-card__titulo">Relatório de Eventos</p>
            <p class="painel-nav-card__desc">Eventos e inscrições do mês atual em PDF.</p>
        </div>
        <div class="painel-nav-card__arrow">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="5" y1="12" x2="19" y2="12"/>
                <polyline points="12 5 19 12 12 19"/>
            </svg>
        </div>
    </a>

</div>

@endsection