@extends('main')

@section('titulo', 'Inscrições · Eclipse Sebo')

@section('content')

<div class="top-bar">
    <div class="heading">
        <p class="tag">Inscrições</p>
        <h1>{{ isset($evento) ? 'Inscrições — ' . $evento->titulo : 'Inscrições' }}</h1>
        <p class="subtitle">Gerencie as inscrições em eventos</p>
    </div>
    <a href="{{ route('inscricoes.create') }}" class="btn btn-primary">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Nova Inscrição
    </a>
</div>

<form method="GET" action="{{ route('inscricoes.search') }}" id="search-form">
    <div class="toolbar">
        <div class="search-wrap" style="max-width:340px;">
            <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/>
                <line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input
                type="text"
                name="search"
                class="search-input"
                id="search-input"
                placeholder="Buscar por usuário, evento ou código..."
                value="{{ request('search') }}"
                autocomplete="off"
            >
            <button
                type="button"
                id="search-clear"
                title="Limpar busca"
                style="
                    position:absolute;
                    right:10px;
                    background:none;
                    border:none;
                    cursor:pointer;
                    color:#999;
                    font-size:1.1rem;
                    line-height:1;
                    padding:0;
                    display:{{ request('search') ? 'block' : 'none' }};
                "
            >×</button>
        </div>

        <span class="count-badge">
            {{ $inscricoes->count() }}
            {{ $inscricoes->count() === 1 ? 'inscrição' : 'inscrições' }}
        </span>
    </div>
</form>

<div class="table-wrap" style="overflow-x:auto;">
    @if ($inscricoes->isEmpty())
        <div class="empty-state">
            @if(request('search'))
                <p>Nenhuma inscrição encontrada para "<strong>{{ request('search') }}</strong>".</p>
                <a href="{{ route('inscricoes.index') }}" class="btn btn-ghost">Limpar busca</a>
            @else
                <p>Nenhuma inscrição registrada ainda.</p>
                <span>Clique em <strong>Nova Inscrição</strong> para começar.</span>
            @endif
        </div>
    @else
        <table style="width:100%; table-layout:auto; min-width:700px;">
            <thead>
                <tr>
                    <th>Usuário</th>
                    <th>Evento</th>
                    <th>Data Inscrição</th>
                    <th>Código</th>
                    <th>Forma Pagamento</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inscricoes as $inscricaoItem)
                    <tr>
                        <td class="td-nome">
                            <strong>{{ optional($inscricaoItem->usuario)->nome ?? '—' }}</strong>
                        </td>
                        <td class="td-title">
                            <strong>{{ optional($inscricaoItem->evento)->titulo ?? '—' }}</strong>
                            <small>{{ optional($inscricaoItem->evento)->data_hora_inicio?->format('d/m/Y H:i') }}</small>
                        </td>
                        <td>{{ $inscricaoItem->data_inscricao ? $inscricaoItem->data_inscricao->format('d/m/Y') : '—' }}</td>
                        <td>
                            <code style="font-size:.85rem; color:var(--purple-lt);">
                                {{ $inscricaoItem->codigo_inscricao }}
                            </code>
                        </td>
                        <td>
                            @php
                                $pagamentoLabel = match($inscricaoItem->forma_pagamento) {
                                    'pix'            => 'Pix',
                                    'cartao_credito' => 'Cartão de Crédito',
                                    'cartao_debito'  => 'Cartão de Débito',
                                    'dinheiro'       => 'Dinheiro',
                                    default          => ucfirst($inscricaoItem->forma_pagamento),
                                };
                            @endphp
                            <span class="badge badge-otimo">{{ $pagamentoLabel }}</span>
                        </td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('inscricoes.edit', $inscricaoItem) }}" class="btn btn-ghost">Editar</a>
                                <form method="POST"
                                      action="{{ route('inscricoes.destroy', $inscricaoItem) }}"
                                      onsubmit="return confirm('Remover esta inscrição?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Remover</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input    = document.getElementById('search-input');
    const clearBtn = document.getElementById('search-clear');
    const form     = document.getElementById('search-form');

    input.addEventListener('input', function () {
        clearBtn.style.display = input.value.length > 0 ? 'block' : 'none';
    });

    input.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            form.submit();
        }
    });

    clearBtn.addEventListener('click', function () {
        window.location.href = "{{ route('inscricoes.index') }}";
    });
});
</script>

@endsection