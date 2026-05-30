@extends('main')

@section('titulo', 'Vendas · Eclipse Sebo')

@section('content')

<div class="top-bar">
    <div class="heading">
        <p class="tag">Gerenciamento</p>
        <h1>Vendas</h1>
        <p class="subtitle">Gerencie as vendas realizadas</p>
    </div>
    <a href="{{ route('vendas.create') }}" class="btn btn-primary">Nova Venda</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="table-wrap">

    @if($vendas->isEmpty())
        <div class="empty-state">
            <p>Nenhuma venda cadastrada.</p>
            <span>Clique em <strong>Nova Venda</strong> para começar.</span>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Data</th>
                    <th>Itens</th>
                    <th>Valor Total</th>
                    <th>Pagamento</th>
                    <th>Status</th>
                    <th style="text-align:right">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vendas as $venda)
                <tr>
                    <td style="color:var(--muted);font-size:.8rem">#{{ $venda->id }}</td>

                    <td>{{ $venda->usuario->nome }}</td>

                    <td>{{ $venda->data_venda->format('d/m/Y') }}</td>

                    <td>
                        <span class="badge badge-items">
                            {{ $venda->itensVenda->count() }}
                            {{ $venda->itensVenda->count() === 1 ? 'item' : 'itens' }}
                        </span>
                    </td>

                    <td class="td-price">
                        R$ {{ number_format($venda->valor_total, 2, ',', '.') }}
                    </td>

                    <td>
                        {{ $venda->pagamento->forma_pagamento ?? '—' }}
                    </td>

                    <td>
                        @php
                            $status = $venda->pagamento->status ?? 'Pendente';
                            $badgeClass = match($status) {
                                'Pago'      => 'badge-pago',
                                'Cancelado' => 'badge-cancelado',
                                default     => 'badge-pendente',
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                    </td>

                    <td>
                        <div class="actions">
                            {{-- Detalhes dos itens (toggle) --}}
                            <button type="button" class="btn btn-ghost btn-sm"
                                    onclick="toggleItens({{ $venda->id }})">
                                Ver Itens
                            </button>

                            <a href="{{ route('vendas.edit', $venda) }}" class="btn btn-ghost btn-sm">
                                Editar
                            </a>

                            <form method="POST" action="{{ route('vendas.destroy', $venda) }}"
                                  onsubmit="return confirm('Remover venda #{{ $venda->id }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                            </form>
                        </div>
                    </td>
                </tr>

                {{-- Linha expandida com os itens --}}
                <tr id="itens-{{ $venda->id }}" class="itens-expanded" style="display:none">
                    <td colspan="8">
                        <div class="itens-detail">
                            <p class="itens-detail-title">Itens da Venda #{{ $venda->id }}</p>
                            @if($venda->itensVenda->isEmpty())
                                <p style="color:var(--muted);font-size:.85rem">Nenhum item registrado.</p>
                            @else
                                <table class="itens-inner-table">
                                    <thead>
                                        <tr>
                                            <th>Livro</th>
                                            <th>Autor</th>
                                            <th>Qtd.</th>
                                            <th>Valor Unit.</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($venda->itensVenda as $item)
                                        <tr>
                                            <td>{{ $item->livro->titulo }}</td>
                                            <td>{{ $item->livro->autor }}</td>
                                            <td>{{ $item->quantidade }}</td>
                                            <td>R$ {{ number_format($item->valor_unitario, 2, ',', '.') }}</td>
                                            <td style="color:var(--gold)">
                                                R$ {{ number_format($item->valor_total, 2, ',', '.') }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</div>

<style>
/* ── BADGES ── */
.badge-items    { background: rgba(167,139,250,.12); color: var(--purple-lt, #c4b5fd); }
.badge-pago     { background: rgba(42,107,60,.2);  color: #6ee7a0; }
.badge-pendente { background: rgba(226,184,90,.12); color: var(--gold, #e2b85a); }
.badge-cancelado{ background: rgba(139,58,42,.2);  color: #f87171; }

.td-price {
    font-variant-numeric: tabular-nums;
    font-weight: 500;
    color: var(--gold, #e2b85a);
}

.btn-sm {
    padding: .38rem .75rem;
    font-size: .78rem;
}

/* ── ITENS EXPANDIDOS ── */
.itens-expanded td {
    padding: 0 !important;
    border-bottom: 1px solid var(--border);
}

.itens-detail {
    padding: 1rem 1.5rem;
    background: rgba(12,11,20,.4);
    border-top: 1px solid rgba(167,139,250,.12);
}

.itens-detail-title {
    font-size: .75rem;
    font-weight: 500;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: var(--purple-lt, #c4b5fd);
    margin-bottom: .75rem;
}

.itens-inner-table {
    width: 100%;
    border-collapse: collapse;
    font-size: .85rem;
}

.itens-inner-table th {
    padding: .4rem .75rem;
    text-align: left;
    font-size: .68rem;
    font-weight: 500;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: var(--muted);
    border-bottom: 1px solid rgba(180,160,255,.1);
}

.itens-inner-table td {
    padding: .45rem .75rem;
    border-bottom: 1px solid rgba(180,160,255,.05);
    color: var(--text-dim);
}

.itens-inner-table tr:last-child td { border-bottom: none; }
</style>

<script>
function toggleItens(id) {
    const row = document.getElementById('itens-' + id);
    row.style.display = row.style.display === 'none' ? 'table-row' : 'none';
}
</script>

@endsection
