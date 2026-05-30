@php
    $editing = isset($venda) && $venda->exists;
    $action  = $editing
        ? route('vendas.update', $venda)
        : route('vendas.store');
@endphp

@extends('main')

@section('titulo', $editing ? 'Editar Venda · Eclipse Sebo' : 'Nova Venda · Eclipse Sebo')

@section('content')

<div class="page-header">
    <p class="tag">Vendas</p>
    <h1>{{ $editing ? 'Editar Venda' : 'Cadastrar Venda' }}</h1>
</div>

@if ($errors->any())
    <div class="alert alert-error">
        <strong>Corrija os erros abaixo:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <form method="POST" action="{{ $action }}" id="venda-form">
        @csrf
        @if($editing) @method('PUT') @endif

        <div class="card-body">
            <div class="form-grid">

                {{-- ── DADOS DA VENDA ── --}}
                <div class="section-divider full"><span>Dados da Venda</span></div>

                <div class="form-group">
                    <label for="usuario_id">Cliente</label>
                    <select id="usuario_id" name="usuario_id" required
                            class="{{ $errors->has('usuario_id') ? 'is-invalid' : '' }}">
                        <option value="">Selecione…</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}"
                                {{ old('usuario_id', $venda->usuario_id ?? '') == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->nome }}
                            </option>
                        @endforeach
                    </select>
                    @error('usuario_id') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="data_venda">Data da Venda</label>
                    <input type="date" id="data_venda" name="data_venda"
                           class="{{ $errors->has('data_venda') ? 'is-invalid' : '' }}"
                           value="{{ old('data_venda', isset($venda) ? $venda->data_venda->format('Y-m-d') : now()->format('Y-m-d')) }}">
                    @error('data_venda') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                {{-- ── ITENS DA VENDA ── --}}
                <div class="section-divider full"><span>Itens da Venda</span></div>

                <div class="full" id="itens-wrap">
                    <table class="itens-table">
                        <thead>
                            <tr>
                                <th>Livro</th>
                                <th style="width:110px">Qtd.</th>
                                <th style="width:160px">Valor Unit. (R$)</th>
                                <th style="width:130px">Subtotal</th>
                                <th style="width:44px"></th>
                            </tr>
                        </thead>
                        <tbody id="itens-body">
                            @if($editing && $venda->itensVenda->count())
                                @foreach($venda->itensVenda as $i => $item)
                                <tr class="item-row">
                                    <td>
                                        <select name="itens[{{ $i }}][livro_id]" class="livro-select" required onchange="syncPrice(this)">
                                            <option value="">Selecione…</option>
                                            @foreach($livros as $livro)
                                                <option value="{{ $livro->id }}"
                                                    data-preco="{{ number_format($livro->preco, 2, '.', '') }}"
                                                    {{ $livro->id == $item->livro_id ? 'selected' : '' }}>
                                                    {{ $livro->titulo }} — {{ $livro->autor }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="itens[{{ $i }}][quantidade]"
                                               class="qty-input" min="1" value="{{ $item->quantidade }}"
                                               required oninput="recalc(this.closest('tr'))">
                                    </td>
                                    <td>
                                        <input type="number" name="itens[{{ $i }}][valor_unitario]"
                                               class="price-input" step="0.01" min="0"
                                               value="{{ number_format($item->valor_unitario, 2, '.', '') }}"
                                               required oninput="recalc(this.closest('tr'))">
                                    </td>
                                    <td class="subtotal-cell">
                                        R$ {{ number_format($item->valor_total, 2, ',', '.') }}
                                    </td>
                                    <td>
                                        <button type="button" class="btn-remove-item" onclick="removeItem(this)" title="Remover">
                                            <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" fill="none" stroke-width="2" stroke-linecap="round">
                                                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr class="item-row">
                                    <td>
                                        <select name="itens[0][livro_id]" class="livro-select" required onchange="syncPrice(this)">
                                            <option value="">Selecione…</option>
                                            @foreach($livros as $livro)
                                                <option value="{{ $livro->id }}"
                                                    data-preco="{{ number_format($livro->preco, 2, '.', '') }}">
                                                    {{ $livro->titulo }} — {{ $livro->autor }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="itens[0][quantidade]" class="qty-input"
                                               min="1" value="1" required oninput="recalc(this.closest('tr'))">
                                    </td>
                                    <td>
                                        <input type="number" name="itens[0][valor_unitario]" class="price-input"
                                               step="0.01" min="0" placeholder="0.00"
                                               required oninput="recalc(this.closest('tr'))">
                                    </td>
                                    <td class="subtotal-cell">R$ 0,00</td>
                                    <td></td>
                                </tr>
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5">
                                    <button type="button" class="btn-add-item" onclick="addItem()">
                                        + Adicionar Item
                                    </button>
                                </td>
                            </tr>
                            <tr class="total-row">
                                <td colspan="3" style="text-align:right;padding-right:1rem">
                                    <strong>Total da Venda</strong>
                                </td>
                                <td colspan="2">
                                    <strong id="total-display">R$ 0,00</strong>
                                    <input type="hidden" name="valor_total" id="valor_total">
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                {{-- ── PAGAMENTO ── --}}
                <div class="section-divider full"><span>Pagamento</span></div>

                <div class="form-group">
                    <label for="forma_pagamento">Forma de Pagamento</label>
                    <select id="forma_pagamento" name="forma_pagamento"
                            class="{{ $errors->has('forma_pagamento') ? 'is-invalid' : '' }}">
                        <option value="">Selecione…</option>
                        @foreach(['Dinheiro','Cartão de Crédito','Cartão de Débito','PIX','Transferência'] as $forma)
                            <option value="{{ $forma }}"
                                {{ old('forma_pagamento', $venda->pagamento->forma_pagamento ?? '') === $forma ? 'selected' : '' }}>
                                {{ $forma }}
                            </option>
                        @endforeach
                    </select>
                    @error('forma_pagamento') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="status_pagamento">Status do Pagamento</label>
                    <select id="status_pagamento" name="status_pagamento"
                            class="{{ $errors->has('status_pagamento') ? 'is-invalid' : '' }}">
                        @foreach(['Pendente','Pago','Cancelado'] as $status)
                            <option value="{{ $status }}"
                                {{ old('status_pagamento', $venda->pagamento->status ?? 'Pendente') === $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                    @error('status_pagamento') <span class="field-error">{{ $message }}</span> @enderror
                </div>

            </div>{{-- /.form-grid --}}
        </div>{{-- /.card-body --}}

        <div class="card-footer">
            <a href="{{ route('vendas.index') }}" class="btn btn-ghost">Cancelar</a>
            <button type="submit" class="btn btn-primary">
                {{ $editing ? 'Salvar Alterações' : 'Cadastrar Venda' }}
            </button>
        </div>

    </form>
</div>

<style>
.itens-table {
    width: 100%;
    border-collapse: collapse;
    font-size: .875rem;
}
.itens-table thead th {
    padding: .6rem .75rem;
    text-align: left;
    font-size: .68rem;
    font-weight: 500;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: var(--muted);
    border-bottom: 1px solid var(--border);
}
.itens-table tbody td {
    padding: .55rem .75rem;
    vertical-align: middle;
    border-bottom: 1px solid rgba(180,160,255,.08);
}
.itens-table tfoot td { padding: .6rem .75rem; }
.itens-table select,
.itens-table input[type="number"] {
    width: 100%;
    padding: .45rem .65rem;
    font-size: .85rem;
    background: var(--deep, #12111f);
    border: 1px solid var(--border);
    border-radius: 4px;
    color: var(--text, #e8e6f5);
    outline: none;
    transition: border-color .2s;
}
.itens-table select:focus,
.itens-table input:focus { border-color: var(--purple, #a78bfa); }
.subtotal-cell {
    font-variant-numeric: tabular-nums;
    color: var(--gold, #e2b85a);
    white-space: nowrap;
}
.total-row { border-top: 1px solid var(--border); }
.total-row strong { font-size: 1rem; color: var(--gold, #e2b85a); }
#total-display { font-size: 1.05rem; font-weight: 600; color: var(--gold, #e2b85a); }
.btn-add-item {
    background: transparent;
    border: 1px dashed var(--border);
    border-radius: 4px;
    color: var(--purple-lt, #c4b5fd);
    font-size: .8rem;
    padding: .45rem 1rem;
    cursor: pointer;
    width: 100%;
    transition: all .2s;
}
.btn-add-item:hover {
    border-color: var(--purple, #a78bfa);
    background: rgba(167,139,250,.06);
}
.btn-remove-item {
    background: transparent;
    border: 1px solid rgba(139,58,42,.3);
    border-radius: 4px;
    color: var(--rust, #c0392b);
    cursor: pointer;
    padding: .35rem .45rem;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all .2s;
}
.btn-remove-item:hover {
    background: rgba(139,58,42,.12);
    border-color: var(--rust, #c0392b);
}
</style>

<script>
// Mapa de preços dos livros: id -> preco
const precosLivros = {
    @foreach($livros as $livro)
        {{ $livro->id }}: {{ number_format($livro->preco, 2, '.', '') }},
    @endforeach
};

// Options HTML para novos itens
const livrosOptions = `
    @foreach($livros as $livro)
    <option value="{{ $livro->id }}" data-preco="{{ number_format($livro->preco, 2, '.', '') }}">{{ addslashes($livro->titulo) }} — {{ addslashes($livro->autor) }}</option>
    @endforeach
`;

let itemIndex = {{ $editing && $venda->itensVenda->count() ? $venda->itensVenda->count() : 1 }};

// Preenche o valor unitário ao selecionar um livro
function syncPrice(select) {
    const option = select.options[select.selectedIndex];
    const preco  = option.dataset.preco || '';
    const row    = select.closest('tr');
    const priceInput = row.querySelector('.price-input');
    if (preco) {
        priceInput.value = parseFloat(preco).toFixed(2);
        recalc(row);
    }
}

function addItem() {
    const tbody = document.getElementById('itens-body');
    const tr = document.createElement('tr');
    tr.className = 'item-row';
    tr.innerHTML = `
        <td>
            <select name="itens[${itemIndex}][livro_id]" class="livro-select" required onchange="syncPrice(this)">
                <option value="">Selecione…</option>
                ${livrosOptions}
            </select>
        </td>
        <td><input type="number" name="itens[${itemIndex}][quantidade]" class="qty-input" min="1" value="1" required oninput="recalc(this.closest('tr'))"></td>
        <td><input type="number" name="itens[${itemIndex}][valor_unitario]" class="price-input" step="0.01" min="0" placeholder="0.00" required oninput="recalc(this.closest('tr'))"></td>
        <td class="subtotal-cell">R$ 0,00</td>
        <td><button type="button" class="btn-remove-item" onclick="removeItem(this)" title="Remover">
            <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" fill="none" stroke-width="2" stroke-linecap="round">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button></td>
    `;
    tbody.appendChild(tr);
    itemIndex++;
    updateTotal();
}

function removeItem(btn) {
    const rows = document.querySelectorAll('.item-row');
    if (rows.length <= 1) return;
    btn.closest('tr').remove();
    updateTotal();
}

function recalc(row) {
    const qty   = parseFloat(row.querySelector('.qty-input').value)   || 0;
    const price = parseFloat(row.querySelector('.price-input').value) || 0;
    const sub   = qty * price;
    row.querySelector('.subtotal-cell').textContent =
        'R$ ' + sub.toFixed(2).replace('.', ',');
    updateTotal();
}

function updateTotal() {
    let total = 0;
    document.querySelectorAll('.item-row').forEach(row => {
        const qty   = parseFloat(row.querySelector('.qty-input').value)   || 0;
        const price = parseFloat(row.querySelector('.price-input').value) || 0;
        total += qty * price;
    });
    document.getElementById('total-display').textContent =
        'R$ ' + total.toLocaleString('pt-BR', { minimumFractionDigits: 2 });
    document.getElementById('valor_total').value = total.toFixed(2);
}

// Listeners nas linhas existentes (edição)
document.querySelectorAll('.item-row').forEach(row => {
    row.querySelector('.qty-input')  ?.addEventListener('input', () => recalc(row));
    row.querySelector('.price-input')?.addEventListener('input', () => recalc(row));
});

document.addEventListener('DOMContentLoaded', updateTotal);
</script>

@endsection
