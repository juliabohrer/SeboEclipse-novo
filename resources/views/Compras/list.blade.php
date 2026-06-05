@extends('main')

@section('titulo', 'Compras · Eclipse Sebo')

@section('content')

<div class="top-bar">

    <div class="heading">

        <p class="tag">Compras</p>

        <h1>Compras de Livros</h1>

        <p class="subtitle">
            Gerencie as aquisições de livros usados para o acervo
        </p>

    </div>

    <a href="{{ route('compras.create') }}" class="btn btn-primary">

        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
            <line x1="12" y1="5"  x2="12" y2="19"/>
            <line x1="5"  y1="12" x2="19" y2="12"/>
        </svg>

        Nova Compra

    </a>

</div>

<div class="toolbar">

    <div class="search-wrap">

        <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"/>
            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>

        <input
            type="text"
            class="search-input"
            id="search-input"
            placeholder="Buscar por fornecedor ou usuário…"
        >

    </div>

    <span class="count-badge" id="count-badge">
        {{ $compras->count() }}
        {{ $compras->count() === 1 ? 'compra' : 'compras' }}
    </span>

</div>

<div class="table-wrap">

    @if ($compras->isEmpty())

        <div class="empty-state">
            <p>Nenhuma compra cadastrada ainda.</p>
            <span>Clique em <strong>Nova Compra</strong> para começar.</span>
        </div>

    @else

        <table id="compras-table">

            <thead>
                <tr>
                    <th></th>
                    <th>Responsável</th>
                    <th>Fornecedor</th>
                    <th>Data</th>
                    <th>Qtd. Livros</th>
                    <th>Valor Total</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($compras as $compra)

                    {{-- Linha principal da compra --}}
                    <tr
                        class="tr-compra"
                        data-search="{{ strtolower(($compra->usuario->nome ?? '') . ' ' . ($compra->fornecedor ?? '')) }}"
                        data-id="{{ $compra->id }}"
                        style="cursor: pointer;"
                        onclick="toggleItens({{ $compra->id }})"
                    >
                        <td style="width: 32px; text-align: center;">
                            <span class="seta" id="seta-{{ $compra->id }}">▶</span>
                        </td>

                        <td class="td-title">
                            <strong>{{ $compra->usuario->nome ?? '—' }}</strong>
                            <small>ID: {{ $compra->usuario->id ?? '—' }}</small>
                        </td>

                        <td>{{ $compra->fornecedor ?? '—' }}</td>

                        <td>{{ $compra->data->format('d/m/Y') }}</td>

                        <td>{{ $compra->itens->count() }} livro(s)</td>

                        <td class="td-price">
                            R$ {{ number_format($compra->valor_total, 2, ',', '.') }}
                        </td>

                        <td onclick="event.stopPropagation()">
                            <div class="actions">

                                <a href="{{ route('compras.edit', $compra) }}"
                                   class="btn btn-ghost">
                                    Editar
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('compras.destroy', $compra) }}"
                                    onsubmit="return confirm('Remover esta compra e todos os seus livros do acervo?')"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        Remover
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>

                    {{-- Linha expandível com os livros --}}
                    <tr class="tr-itens" id="itens-{{ $compra->id }}" style="display: none;">
                        <td colspan="7" style="padding: 0;">

                            <div style="padding: 1rem 2rem; background: rgba(255,255,255,0.03); border-top: 1px solid rgba(255,255,255,0.07);">

                                <p style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.08em; opacity: 0.5; margin-bottom: 0.75rem;">
                                    Livros desta compra
                                </p>

                                <table style="width: 100%; font-size: 0.875rem;">
                                    <thead>
                                        <tr style="opacity: 0.6;">
                                            <th style="text-align: left; padding: 0.25rem 0.5rem;">Título</th>
                                            <th style="text-align: left; padding: 0.25rem 0.5rem;">Autor</th>
                                            <th style="text-align: left; padding: 0.25rem 0.5rem;">Gênero</th>
                                            <th style="text-align: left; padding: 0.25rem 0.5rem;">Editora</th>
                                            <th style="text-align: left; padding: 0.25rem 0.5rem;">Estado</th>
                                            <th style="text-align: right; padding: 0.25rem 0.5rem;">Vl. Pago</th>
                                            <th style="text-align: right; padding: 0.25rem 0.5rem;">Preço Venda</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($compra->itens as $item)
                                            <tr style="border-top: 1px solid rgba(255,255,255,0.05);">
                                                <td style="padding: 0.4rem 0.5rem;"><strong>{{ $item->titulo }}</strong></td>
                                                <td style="padding: 0.4rem 0.5rem;">{{ $item->autor }}</td>
                                                <td style="padding: 0.4rem 0.5rem;">{{ $item->genero }}</td>
                                                <td style="padding: 0.4rem 0.5rem;">{{ $item->editora }}</td>
                                                <td style="padding: 0.4rem 0.5rem;">{{ $item->estado_conservacao }}</td>
                                                <td style="padding: 0.4rem 0.5rem; text-align: right;">
                                                    R$ {{ number_format($item->valor_pago, 2, ',', '.') }}
                                                </td>
                                                <td style="padding: 0.4rem 0.5rem; text-align: right;">
                                                    R$ {{ number_format($item->preco_venda, 2, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>

        </td>
                    </tr>

                @endforeach

            </tbody>

        </table>

    @endif

</div>

<script>
    function toggleItens(id) {
        const linha = document.getElementById('itens-' + id);
        const seta  = document.getElementById('seta-' + id);

        if (linha.style.display === 'none') {
            linha.style.display = '';
            seta.textContent = '▼';
        } else {
            linha.style.display = 'none';
            seta.textContent = '▶';
        }
    }

    const input = document.getElementById('search-input');
    const badge = document.getElementById('count-badge');

    if (input) {
        input.addEventListener('input', () => {
            const term = input.value.toLowerCase().trim();
            let visible = 0;

            document.querySelectorAll('.tr-compra').forEach(row => {
                const match = !term || (row.dataset.search || '').includes(term);
                const id = row.dataset.id;
                row.style.display = match ? '' : 'none';

                // Esconde também a linha de itens se a compra for filtrada
                const linhaItens = document.getElementById('itens-' + id);
                if (linhaItens && !match) linhaItens.style.display = 'none';

                if (match) visible++;
            });

            if (badge) {
                badge.textContent = `${visible} ${visible === 1 ? 'compra' : 'compras'}`;
            }
        });
    }
</script>

@endsection
