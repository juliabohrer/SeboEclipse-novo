@extends('main')

@section('titulo', 'Itens da Venda · Eclipse Sebo')

@section('content')

<div class="top-bar">

    <div class="heading">

        <p class="tag">Vendas</p>

        <h1>Itens da Venda</h1>

    </div>

    <a href="{{ route('itens-venda.create') }}"
       class="btn btn-primary">

        Novo Item

    </a>

</div>

<div class="table-wrap">

<table>

    <thead>

        <tr>

            <th>Venda</th>
            <th>Livro</th>
            <th>Quantidade</th>
            <th>Valor Unitário</th>
            <th>Total</th>
            <th>Ações</th>

        </tr>

    </thead>

    <tbody>

        @foreach($itens as $item)

        <tr>

            <td>
                #{{ $item->venda_id }}
            </td>

            <td>
                {{ $item->livro->titulo }}
            </td>

            <td>
                {{ $item->quantidade }}
            </td>

            <td>

                R$

                {{ number_format(
                    $item->valor_unitario,
                    2,
                    ',',
                    '.'
                ) }}

            </td>

            <td>

                R$

                {{ number_format(
                    $item->valor_total,
                    2,
                    ',',
                    '.'
                ) }}

            </td>

            <td>

                <div class="actions">

                    <a
                        href="{{ route(
                            'itens-venda.edit',
                            $item
                        ) }}"

                        class="btn btn-ghost"
                    >

                        Editar

                    </a>

                </div>

            </td>

        </tr>

        @endforeach

    </tbody>

</table>

</div>

@endsection