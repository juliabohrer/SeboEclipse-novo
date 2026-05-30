@extends('main')

@section('titulo', 'Compras · Eclipse Sebo')

@section('content')

<div class="top-bar">

    <div class="heading">

        <p class="tag">
            Compras
        </p>

        <h1>
            Compras de Livros
        </h1>

        <p class="subtitle">
            Gerencie as compras realizadas no sistema
        </p>

    </div>

    <a href="{{ route('compras.create') }}"
       class="btn btn-primary">

        <svg width="14"
             height="14"
             viewBox="0 0 24 24"
             fill="none"
             stroke="currentColor"
             stroke-width="2.5"
             stroke-linecap="round">

            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>

        </svg>

        Nova Compra

    </a>

</div>

<div class="toolbar">

    <div class="search-wrap">

        <svg viewBox="0 0 24 24"
             stroke-linecap="round"
             stroke-linejoin="round">

            <circle cx="11" cy="11" r="8"/>
            <line x1="21" y1="21" x2="16.65" y2="16.65"/>

        </svg>

        <input type="text"
               class="search-input"
               id="search-input"
               placeholder="Buscar por usuário ou livro…">

    </div>

    <span class="count-badge"
          id="count-badge">

        {{ $compras->count() }}
        {{ $compras->count() === 1 ? 'compra' : 'compras' }}

    </span>

</div>

<div class="table-wrap">

    @if ($compras->isEmpty())

        <div class="empty-state">

            <p>
                Nenhuma compra cadastrada ainda.
            </p>

            <span>
                Clique em
                <strong>Nova Compra</strong>
                para começar.
            </span>

        </div>

    @else

        <table id="compras-table">

            <thead>

                <tr>
                    <th>Usuário</th>
                    <th>Livro</th>
                    <th>Data</th>
                    <th>Valor Pago</th>
                    <th>Ações</th>
                </tr>

            </thead>

            <tbody>

                @foreach ($compras as $compra)

                    <tr
                        data-search="{{ strtolower(
                            $compra->usuario->nome .
                            ' ' .
                            $compra->livro->titulo
                        ) }}"
                    >

                        <td class="td-title">

                            <strong>
                                {{ $compra->usuario->nome }}
                            </strong>

                            <small>
                                ID:
                                {{ $compra->usuario->id }}
                            </small>

                        </td>

                        <td>
                            {{ $compra->livro->titulo }}
                        </td>

                        <td>
                            {{ $compra->data->format('d/m/Y') }}
                        </td>

                        <td class="td-price">

                            R$
                            {{ number_format(
                                $compra->valor_pago,
                                2,
                                ',',
                                '.'
                            ) }}

                        </td>

                        <td>

                            <div class="actions">

                                <a href="{{ route('compras.edit', $compra) }}"
                                   class="btn btn-ghost">

                                    Editar

                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('compras.destroy', $compra) }}"
                                    onsubmit="return confirm(
                                        'Remover esta compra?'
                                    )"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-danger">

                                        Remover

                                    </button>

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

    const input = document.getElementById(
        'search-input'
    );

    const badge = document.getElementById(
        'count-badge'
    );

    const rows = document.querySelectorAll(
        '#compras-table tbody tr'
    );

    if (input) {

        input.addEventListener('input', () => {

            const term = input.value
                .toLowerCase()
                .trim();

            let visible = 0;

            rows.forEach(row => {

                const match =
                    !term ||
                    (
                        row.dataset.search || ''
                    ).includes(term);

                row.style.display =
                    match ? '' : 'none';

                if (match) visible++;

            });

            if (badge) {

                badge.textContent =
                    `${visible} ${
                        visible === 1
                            ? 'compra'
                            : 'compras'
                    }`;

            }

        });

    }

</script>

@endsection
