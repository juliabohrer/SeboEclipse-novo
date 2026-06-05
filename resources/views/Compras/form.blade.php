@php
    $editing = isset($compra) && $compra->exists;
    $action  = $editing
        ? route('compras.update', $compra)
        : route('compras.store');
    $itens = old('itens', $editing ? $compra->itens->toArray() : [[]]);
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
        {{ $editing ? 'Atualizar registro' : 'Novo registro' }}
    </p>

    <h1>
        {{ $editing ? 'Editar Compra' : 'Cadastrar Compra' }}
    </h1>

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

    <form method="POST" action="{{ $action }}">

        @csrf

        @if ($editing)
            @method('PUT')
        @endif

        <div class="card-body">

            <div class="form-grid">

                {{-- ── Dados da Compra ── --}}
                <div class="section-divider full">
                    <span>Dados da Compra</span>
                </div>

                <div class="form-group">

                    <label for="usuario_id">Usuário</label>

                    <select
                        id="usuario_id"
                        name="usuario_id"
                        class="{{ $errors->has('usuario_id') ? 'is-invalid' : '' }}"
                    >
                        <option value="">Selecione…</option>

                        @foreach ($usuarios as $usuario)
                            <option
                                value="{{ $usuario->id }}"
                                {{ old('usuario_id', $compra->usuario_id ?? '') == $usuario->id ? 'selected' : '' }}
                            >
                                {{ $usuario->nome }}
                            </option>
                        @endforeach

                    </select>

                    @error('usuario_id')
                        <span class="field-error">{{ $message }}</span>
                    @enderror

                </div>

                <div class="form-group">

                    <label for="fornecedor">Fornecedor</label>

                    <input
                        type="text"
                        id="fornecedor"
                        name="fornecedor"
                        value="{{ old('fornecedor', $compra->fornecedor ?? '') }}"
                        placeholder="Ex.: Livraria Cultura"
                        class="{{ $errors->has('fornecedor') ? 'is-invalid' : '' }}"
                    >

                    @error('fornecedor')
                        <span class="field-error">{{ $message }}</span>
                    @enderror

                </div>

                <div class="form-group">

                    <label for="data">Data da Compra</label>

                    <input
                        type="date"
                        id="data"
                        name="data"
                        value="{{ old('data', isset($compra) ? $compra->data->format('Y-m-d') : '') }}"
                        class="{{ $errors->has('data') ? 'is-invalid' : '' }}"
                    >

                    @error('data')
                        <span class="field-error">{{ $message }}</span>
                    @enderror

                </div>

                {{-- ── Livros Adquiridos ── --}}
                <div class="section-divider full">
                    <span>Livros Adquiridos</span>
                </div>

                <div class="full" id="itens-container">

                    @foreach ($itens as $i => $item)

                        <div class="item-livro card" style="margin-bottom: 1rem; padding: 1rem;">

                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 0.75rem;">

                                <strong>
                                    Livro <span class="num-item">{{ $i + 1 }}</span>
                                </strong>

                                @if ($i > 0)
                                    <button
                                        type="button"
                                        class="btn btn-danger btn-remove"
                                        style="padding: 0.25rem 0.75rem; font-size: 0.8rem;"
                                    >
                                        Remover
                                    </button>
                                @endif

                            </div>

                            <div class="form-grid">

                                <div class="form-group full">
                                    <label>Título</label>
                                    <input
                                        type="text"
                                        name="itens[{{ $i }}][titulo]"
                                        value="{{ old("itens.$i.titulo", $item['titulo'] ?? '') }}"
                                        placeholder="Ex.: Dom Casmurro"
                                        class="{{ $errors->has("itens.$i.titulo") ? 'is-invalid' : '' }}"
                                        required
                                    >
                                    @error("itens.$i.titulo")
                                        <span class="field-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Autor</label>
                                    <input
                                        type="text"
                                        name="itens[{{ $i }}][autor]"
                                        value="{{ old("itens.$i.autor", $item['autor'] ?? '') }}"
                                        placeholder="Ex.: Machado de Assis"
                                        required
                                    >
                                </div>

                                <div class="form-group">
                                    <label>Editora</label>
                                    <input
                                        type="text"
                                        name="itens[{{ $i }}][editora]"
                                        value="{{ old("itens.$i.editora", $item['editora'] ?? '') }}"
                                        placeholder="Ex.: Companhia das Letras"
                                        required
                                    >
                                </div>

                                <div class="form-group">
                                    <label>Gênero</label>
                                    <input
                                        type="text"
                                        name="itens[{{ $i }}][genero]"
                                        value="{{ old("itens.$i.genero", $item['genero'] ?? '') }}"
                                        placeholder="Ex.: Romance"
                                        required
                                    >
                                </div>

                                <div class="form-group">
                                    <label>Estado de Conservação</label>
                                    <select
                                        name="itens[{{ $i }}][estado_conservacao]"
                                        class="{{ $errors->has("itens.$i.estado_conservacao") ? 'is-invalid' : '' }}"
                                        required
                                    >
                                        <option value="" disabled
                                            {{ old("itens.$i.estado_conservacao", $item['estado_conservacao'] ?? '') === '' ? 'selected' : '' }}
                                        >
                                            Selecione…
                                        </option>
                                        @foreach (['Novo', 'Ótimo', 'Bom', 'Regular', 'Ruim'] as $estado)
                                            <option
                                                value="{{ $estado }}"
                                                {{ old("itens.$i.estado_conservacao", $item['estado_conservacao'] ?? '') === $estado ? 'selected' : '' }}
                                            >
                                                {{ $estado }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error("itens.$i.estado_conservacao")
                                        <span class="field-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Preço de Venda (R$)</label>
                                    <input
                                        type="number"
                                        name="itens[{{ $i }}][preco_venda]"
                                        value="{{ old("itens.$i.preco_venda", $item['preco_venda'] ?? '') }}"
                                        placeholder="0.00"
                                        step="0.01"
                                        min="0"
                                        required
                                    >
                                </div>

                                <div class="form-group">
                                    <label>Valor Pago (R$)</label>
                                    <input
                                        type="number"
                                        name="itens[{{ $i }}][valor_pago]"
                                        value="{{ old("itens.$i.valor_pago", $item['valor_pago'] ?? '') }}"
                                        placeholder="0.00"
                                        step="0.01"
                                        min="0"
                                        required
                                    >
                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

                <div class="full">
                    <button type="button" id="btn-add-item" class="btn btn-ghost">
                        + Adicionar Livro
                    </button>
                </div>

            </div>

        </div>

        <div class="card-footer">

            <a href="{{ route('compras.index') }}" class="btn btn-ghost">
                Cancelar
            </a>

            <button type="submit" class="btn btn-primary">
                {{ $editing ? 'Salvar Alterações' : 'Cadastrar Compra' }}
            </button>

        </div>

    </form>

</div>

<script>
    let itemCount = {{ count($itens) }};

    const container = document.getElementById('itens-container');

    document.getElementById('btn-add-item').addEventListener('click', function () {

        const primeiro = container.querySelector('.item-livro');
        const clone    = primeiro.cloneNode(true);

        clone.querySelectorAll('[name]').forEach(el => {
            el.name  = el.name.replace(/itens\[\d+\]/, `itens[${itemCount}]`);
            el.value = '';
            if (el.tagName === 'SELECT') el.selectedIndex = 0;
        });

        clone.querySelector('.num-item').textContent = itemCount + 1;

        let removeBtn = clone.querySelector('.btn-remove');
        if (!removeBtn) {
            const header  = clone.querySelector('div[style*="justify-content"]');
            removeBtn     = document.createElement('button');
            removeBtn.type        = 'button';
            removeBtn.className   = 'btn btn-danger btn-remove';
            removeBtn.style       = 'padding: 0.25rem 0.75rem; font-size: 0.8rem;';
            removeBtn.textContent = 'Remover';
            header.appendChild(removeBtn);
        }

        container.appendChild(clone);
        itemCount++;
        bindRemove();
    });

    function bindRemove() {
        container.querySelectorAll('.btn-remove').forEach(btn => {
            btn.onclick = function () {
                this.closest('.item-livro').remove();
                renumber();
            };
        });
    }

    function renumber() {
        container.querySelectorAll('.item-livro').forEach((el, i) => {
            el.querySelector('.num-item').textContent = i + 1;
            el.querySelectorAll('[name]').forEach(input => {
                input.name = input.name.replace(/itens\[\d+\]/, `itens[${i}]`);
            });
        });
        itemCount = container.querySelectorAll('.item-livro').length;
    }

    bindRemove();
</script>

@endsection