@php
    $editing = isset($livro) && $livro->exists;
    $action  = $editing ? route('livros.update', $livro) : route('livros.store');
@endphp

@extends('main')

@section('titulo', $editing ? 'Editar Livro · Eclipse Sebo' : 'Novo Livro · Eclipse Sebo')

@section('content')

<style>
    .field-error {
        color: #e53e3e;
        font-size: 0.82rem;
        margin-top: 4px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .field-error::before {
        content: '⚠ ';
    }
    input.is-invalid,
    select.is-invalid {
        border-color: #e53e3e !important;
        outline-color: #e53e3e;
    }
</style>

<div class="page-header">
    <p class="tag">{{ $editing ? 'Atualizar registro' : 'Novo registro' }}</p>
    <h1>{{ $editing ? 'Editar Livro' : 'Cadastrar Livro' }}</h1>
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
    <form method="POST" action="{{ $action }}" enctype="multipart/form-data"
          id="livro-form" novalidate>
        @csrf
        @if ($editing)
            @method('PUT')
        @endif

        <div class="card-body">
            <div class="form-grid">

                <div class="section-divider full">
                    <span>Identificação</span>
                </div>

                <div class="form-group full">
                    <label for="titulo">Título *</label>
                    <input
                        type="text"
                        id="titulo"
                        name="titulo"
                        value="{{ old('titulo', $livro->titulo ?? '') }}"
                        placeholder="Ex.: Dom Casmurro"
                        class="{{ $errors->has('titulo') ? 'is-invalid' : '' }}"
                        required
                    >
                    @error('titulo')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="autor">Autor *</label>
                    <input
                        type="text"
                        id="autor"
                        name="autor"
                        value="{{ old('autor', $livro->autor ?? '') }}"
                        placeholder="Ex.: Machado de Assis"
                        class="{{ $errors->has('autor') ? 'is-invalid' : '' }}"
                        required
                    >
                    @error('autor')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="editora">Editora</label>
                    <input
                        type="text"
                        id="editora"
                        name="editora"
                        value="{{ old('editora', $livro->editora ?? '') }}"
                        placeholder="Ex.: Companhia das Letras"
                        class="{{ $errors->has('editora') ? 'is-invalid' : '' }}"
                    >
                    @error('editora')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group full">
                    <label for="imagem">Imagem do Livro</label>

                    <input
                        type="file"
                        id="imagem"
                        name="imagem"
                        accept="image/png,image/jpeg,image/jpg,image/webp"
                    >

                    <div style="margin-top: 10px;">
                        <img
                            src="{{ $editing && !empty($livro->imagem) ? asset('storage/' . $livro->imagem) : asset('images/sem-imagem.png') }}"
                            alt="Imagem do livro"
                            width="120"
                            style="border-radius:8px; border:1px solid #ddd;"
                        >
                    </div>

                    @error('imagem')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="section-divider full">
                    <span>Classificação & Preço</span>
                </div>

                <div class="form-group">
                    <label for="genero">Gênero *</label>
                    <input
                        type="text"
                        id="genero"
                        name="genero"
                        value="{{ old('genero', $livro->genero ?? '') }}"
                        placeholder="Ex.: Romance"
                        class="{{ $errors->has('genero') ? 'is-invalid' : '' }}"
                        required
                    >
                    @error('genero')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="preco">Preço (R$) *</label>
                    <input
                        type="number"
                        id="preco"
                        name="preco"
                        value="{{ old('preco', $livro->preco ?? '') }}"
                        placeholder="0.00"
                        step="0.01"
                        min="0"
                        class="{{ $errors->has('preco') ? 'is-invalid' : '' }}"
                        required
                    >
                    @error('preco')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="estado_conservacao">Estado de Conservação *</label>
                    <select
                        id="estado_conservacao"
                        name="estado_conservacao"
                        class="{{ $errors->has('estado_conservacao') ? 'is-invalid' : '' }}"
                        required
                    >
                        <option value="">Selecione...</option>

                        @foreach (['Novo', 'Ótimo', 'Bom', 'Regular', 'Ruim'] as $estado)
                            <option
                                value="{{ $estado }}"
                                {{ old('estado_conservacao', $livro->estado_conservacao ?? '') == $estado ? 'selected' : '' }}
                            >
                                {{ $estado }}
                            </option>
                        @endforeach
                    </select>

                    @error('estado_conservacao')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="section-divider full">
                    <span>Disponibilidade</span>
                </div>

                <div class="form-group full">
                    <label class="checkbox-row" for="disponivel">
                        <input type="hidden" name="disponivel" value="0">

                        <input
                            type="checkbox"
                            id="disponivel"
                            name="disponivel"
                            value="1"
                            {{ old('disponivel', $livro->disponivel ?? true) ? 'checked' : '' }}
                        >

                        <span class="cb-label">
                            Disponível para venda / troca
                        </span>

                        <span class="cb-hint">
                            Desmarque se o livro não estiver disponível
                        </span>
                    </label>
                </div>

            </div>
        </div>

        <div class="card-footer">
            <a href="{{ route('livros.index') }}" class="btn btn-ghost">
                Cancelar
            </a>

            <button type="submit" class="btn btn-primary">
                {{ $editing ? 'Salvar Alterações' : 'Cadastrar Livro' }}
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('livro-form');

    // Campos obrigatórios: [id do input, mensagem]
    const campos = [
        { id: 'titulo',             msg: 'O título é obrigatório.' },
        { id: 'autor',              msg: 'O autor é obrigatório.' },
        { id: 'genero',             msg: 'O gênero é obrigatório.' },
        { id: 'preco',              msg: 'O preço é obrigatório.' },
        { id: 'estado_conservacao', msg: 'Selecione o estado de conservação.' },
    ];

    // Remove erro quando usuário começa a digitar/selecionar
    campos.forEach(function (campo) {
        const el = document.getElementById(campo.id);
        if (!el) return;
        el.addEventListener('input',  function () { limparErro(el); });
        el.addEventListener('change', function () { limparErro(el); });
    });

    form.addEventListener('submit', function (e) {
        let valido = true;

        // Limpa apenas os erros gerados pelo JS (não toca nos do Laravel)
        form.querySelectorAll('.js-error').forEach(function (el) { el.remove(); });
        form.querySelectorAll('.js-invalid').forEach(function (el) {
            el.classList.remove('is-invalid', 'js-invalid');
        });

        campos.forEach(function (campo) {
            const el = document.getElementById(campo.id);
            if (!el) return;

            if (el.value.trim() === '') {
                mostrarErro(el, campo.msg);
                valido = false;
            }
        });

        if (!valido) {
            e.preventDefault();
            // Rola até o primeiro campo com erro
            const primeiro = form.querySelector('.is-invalid');
            if (primeiro) {
                primeiro.scrollIntoView({ behavior: 'smooth', block: 'center' });
                primeiro.focus();
            }
        }
    });

    function mostrarErro(el, msg) {
        el.classList.add('is-invalid', 'js-invalid');
        const span = document.createElement('span');
        span.className = 'field-error js-error';
        span.textContent = msg;
        el.insertAdjacentElement('afterend', span);
    }

    function limparErro(el) {
        el.classList.remove('is-invalid', 'js-invalid');
        const erro = el.parentElement.querySelector('.js-error');
        if (erro) erro.remove();
    }
});
</script>

@endsection
