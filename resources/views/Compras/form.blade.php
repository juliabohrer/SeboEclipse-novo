@php
    $editing = isset($compra) && $compra->exists;

    $action = $editing
        ? route('compras.update', $compra)
        : route('compras.store');
@endphp

@extends('main')

@section(
    'titulo',
    $editing
        ? 'Editar Compra · Eclipse Sebo'
        : 'Nova Compra · Eclipse Sebo'
)

@section('content')

<div class="page-header">

    <p class="tag">
        {{ $editing
            ? 'Atualizar registro'
            : 'Novo registro' }}
    </p>

    <h1>
        {{ $editing
            ? 'Editar Compra'
            : 'Cadastrar Compra' }}
    </h1>

</div>

@if ($errors->any())

    <div class="alert alert-error">

        <strong>
            Corrija os erros abaixo:
        </strong>

        <ul>

            @foreach ($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif

<div class="card">

    <form method="POST" action="{{ $action }}">

        @csrf

        @if ($editing)
            @method('PUT')
        @endif

        <div class="card-body">

            <div class="form-grid">

                <div class="section-divider full">
                    <span>Dados da Compra</span>
                </div>

                <div class="form-group">

                    <label for="usuario_id">
                        Usuário
                    </label>

                    <select
                        id="usuario_id"
                        name="usuario_id"
                        class="{{ $errors->has('usuario_id') ? 'is-invalid' : '' }}"
                    >

                        <option value="">
                            Selecione…
                        </option>

                        @foreach ($usuarios as $usuario)

                            <option
                                value="{{ $usuario->id }}"

                                {{ old(
                                    'usuario_id',
                                    $compra->usuario_id ?? ''
                                ) == $usuario->id
                                    ? 'selected'
                                    : '' }}
                            >

                                {{ $usuario->nome }}

                            </option>

                        @endforeach

                    </select>

                    @error('usuario_id')

                        <span class="field-error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>

                <div class="form-group">

                    <label for="livro_id">
                        Livro
                    </label>

                    <select
                        id="livro_id"
                        name="livro_id"
                        class="{{ $errors->has('livro_id') ? 'is-invalid' : '' }}"
                    >

                        <option value="">
                            Selecione…
                        </option>

                        @foreach ($livros as $livro)

                            <option
                                value="{{ $livro->id }}"

                                {{ old(
                                    'livro_id',
                                    $compra->livro_id ?? ''
                                ) == $livro->id
                                    ? 'selected'
                                    : '' }}
                            >

                                {{ $livro->titulo }}

                            </option>

                        @endforeach

                    </select>

                    @error('livro_id')

                        <span class="field-error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>

                <div class="section-divider full">
                    <span>Pagamento</span>
                </div>

                <div class="form-group">

                    <label for="data">
                        Data da Compra
                    </label>

                    <input
                        type="date"
                        id="data"
                        name="data"

                        value="{{ old(
                            'data',
                            isset($compra)
                                ? $compra->data->format('Y-m-d')
                                : ''
                        ) }}"

                        class="{{ $errors->has('data') ? 'is-invalid' : '' }}"
                    >

                    @error('data')

                        <span class="field-error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>

                <div class="form-group">

                    <label for="valor_pago">
                        Valor Pago (R$)
                    </label>

                    <input
                        type="number"
                        id="valor_pago"
                        name="valor_pago"
                        step="0.01"
                        min="0"

                        value="{{ old(
                            'valor_pago',
                            $compra->valor_pago ?? ''
                        ) }}"

                        placeholder="0.00"

                        class="{{ $errors->has('valor_pago') ? 'is-invalid' : '' }}"
                    >

                    @error('valor_pago')

                        <span class="field-error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>

            </div>

        </div>

        <div class="card-footer">

            <a href="{{ route('compras.index') }}"
               class="btn btn-ghost">

                Cancelar

            </a>

            <button type="submit"
                    class="btn btn-primary">

                {{ $editing
                    ? 'Salvar Alterações'
                    : 'Cadastrar Compra' }}

            </button>

        </div>

    </form>

</div>

@endsection
