@php
$editing = isset($itemVenda) && $itemVenda->exists;

$action = $editing
    ? route('itens-venda.update', $itemVenda)
    : route('itens-venda.store');
@endphp

@extends('main')

@section('titulo', 'Item da Venda · Eclipse Sebo')

@section('content')

<div class="page-header">
    <p class="tag">Vendas</p>
    <h1>{{ $editing ? 'Editar Item' : 'Novo Item' }}</h1>
</div>

<div class="card">

<form method="POST" action="{{ $action }}">
    @csrf

    @if($editing)
        @method('PUT')
    @endif

    <div class="card-body">

        <div class="form-grid">

            <div class="form-group">
                <label>Venda</label>

                <select name="venda_id" required>

                    <option value="">Selecione</option>

                    @foreach($vendas as $venda)

                        <option
                            value="{{ $venda->id }}"
                            {{
                                old(
                                    'venda_id',
                                    $itemVenda->venda_id ?? ''
                                ) == $venda->id
                                ? 'selected'
                                : ''
                            }}
                        >
                            Venda #{{ $venda->id }}
                        </option>

                    @endforeach

                </select>

            </div>

            <div class="form-group">

                <label>Livro</label>

                <select name="livro_id" required>

                    <option value="">Selecione</option>

                    @foreach($livros as $livro)

                        <option
                            value="{{ $livro->id }}"
                            {{
                                old(
                                    'livro_id',
                                    $itemVenda->livro_id ?? ''
                                ) == $livro->id
                                ? 'selected'
                                : ''
                            }}
                        >
                            {{ $livro->titulo }}
                        </option>

                    @endforeach

                </select>

            </div>

            <div class="form-group">

                <label>Valor Unitário</label>

                <input
                    type="number"
                    step="0.01"
                    min="0"
                    name="valor_unitario"

                    value="{{ old(
                        'valor_unitario',
                        $itemVenda->valor_unitario ?? ''
                    ) }}"
                >

            </div>

            <div class="form-group">

                <label>Quantidade</label>

                <input
                    type="number"
                    min="1"
                    name="quantidade"

                    value="{{ old(
                        'quantidade',
                        $itemVenda->quantidade ?? 1
                    ) }}"
                >

            </div>

        </div>

    </div>

    <div class="card-footer">

        <a href="{{ route('itens-venda.index') }}"
           class="btn btn-ghost">

            Cancelar

        </a>

        <button type="submit"
                class="btn btn-primary">

            Salvar

        </button>

    </div>

</form>

</div>

@endsection