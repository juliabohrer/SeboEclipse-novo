@php
    $editing = isset($livro) && $livro->exists;
    $action  = $editing ? route('livros.update', $livro) : route('livros.store');
@endphp

@extends('main')

@section('titulo', $editing ? 'Editar Livro · Eclipse Sebo' : 'Novo Livro · Eclipse Sebo')

@section('content')

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
    <form method="POST" action="{{ $action }}">
        @csrf
        @if ($editing) @method('PUT') @endif

        <div class="card-body">
            <div class="form-grid">

                <div class="section-divider full"><span>Identificação</span></div>

                <div class="form-group full">
                    <label for="titulo">Título</label>
                    <input type="text" id="titulo" name="titulo"
                        value="{{ old('titulo', $livro->titulo ?? '') }}"
                        placeholder="Ex.: Dom Casmurro"
                        class="{{ $errors->has('titulo') ? 'is-invalid' : '' }}">
                    @error('titulo') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="autor">Autor</label>
                    <input type="text" id="autor" name="autor"
                        value="{{ old('autor', $livro->autor ?? '') }}"
                        placeholder="Ex.: Machado de Assis"
                        class="{{ $errors->has('autor') ? 'is-invalid' : '' }}">
                    @error('autor') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="editora">Editora</label>
                    <input type="text" id="editora" name="editora"
                        value="{{ old('editora', $livro->editora ?? '') }}"
                        placeholder="Ex.: Companhia das Letras"
                        class="{{ $errors->has('editora') ? 'is-invalid' : '' }}">
                    @error('editora') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="section-divider full"><span>Classificação &amp; Preço</span></div>

                <div class="form-group">
                    <label for="genero">Gênero</label>
                    <input type="text" id="genero" name="genero"
                        value="{{ old('genero', $livro->genero ?? '') }}"
                        placeholder="Ex.: Romance"
                        class="{{ $errors->has('genero') ? 'is-invalid' : '' }}">
                    @error('genero') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="preco">Preço (R$)</label>
                    <input type="number" id="preco" name="preco"
                        value="{{ old('preco', $livro->preco ?? '') }}"
                        placeholder="0.00" step="0.01" min="0"
                        class="{{ $errors->has('preco') ? 'is-invalid' : '' }}">
                    @error('preco') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="estado_conservacao">Estado de Conservação</label>
                    <select id="estado_conservacao" name="estado_conservacao"
                        class="{{ $errors->has('estado_conservacao') ? 'is-invalid' : '' }}">
                        <option value="" disabled {{ old('estado_conservacao', $livro->estado_conservacao ?? '') === '' ? 'selected' : '' }}>Selecione…</option>
                        @foreach (['Novo', 'Ótimo', 'Bom', 'Regular', 'Ruim'] as $estado)
                            <option value="{{ $estado }}"
                                {{ old('estado_conservacao', $livro->estado_conservacao ?? '') === $estado ? 'selected' : '' }}>
                                {{ $estado }}
                            </option>
                        @endforeach
                    </select>
                    @error('estado_conservacao') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="section-divider full"><span>Disponibilidade</span></div>

                <div class="form-group full">
                    <label class="checkbox-row" for="disponivel">
                        <input type="hidden" name="disponivel" value="0">
                        <input type="checkbox" id="disponivel" name="disponivel" value="1"
                            {{ old('disponivel', $livro->disponivel ?? true) ? 'checked' : '' }}>
                        <span class="cb-label">Disponível para venda / troca</span>
                        <span class="cb-hint">Desmarque se o livro não estiver disponível</span>
                    </label>
                </div>

            </div>
        </div>

        <div class="card-footer">
            <a href="{{ route('livros.index') }}" class="btn btn-ghost">Cancelar</a>
            <button type="submit" class="btn btn-primary">
                {{ $editing ? 'Salvar Alterações' : 'Cadastrar Livro' }}
            </button>
        </div>
    </form>
</div>

@endsection