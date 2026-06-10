@php
    $editing    = isset($trocaLivro) && $trocaLivro->exists;
    $action     = $editing ? route('troca-livros.update', $trocaLivro) : route('troca-livros.store');
@endphp

@extends('main')

@section('titulo', $editing ? 'Editar Troca · Eclipse Sebo' : 'Nova Troca · Eclipse Sebo')

@section('content')

<div class="page-header">
    <p class="tag">{{ $editing ? 'Atualizar registro' : 'Novo registro' }}</p>
    <h1>{{ $editing ? 'Editar Troca' : 'Registrar Troca' }}</h1>
</div>

@if ($errors->any())
    <div class="alert-error">
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

                <div class="section-divider full"><span>Participante</span></div>

                <div class="form-group full">
                    <label for="usuario_id">Usuário</label>
                    <select id="usuario_id" name="usuario_id"
                        class="{{ $errors->has('usuario_id') ? 'is-invalid' : '' }}">
                        <option value="" disabled {{ old('usuario_id', $trocaLivro->usuario_id ?? '') === '' ? 'selected' : '' }}>Selecione um usuário…</option>
                        @foreach ($usuarios as $usuario)
                            <option value="{{ $usuario->id }}"
                                {{ old('usuario_id', $trocaLivro->usuario_id ?? '') == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->nome }}
                            </option>
                        @endforeach
                    </select>
                    @error('usuario_id') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="section-divider full"><span>Livros</span></div>

                {{-- Livro Novo: somente disponíveis (do acervo) --}}
                <div class="form-group">
                    <label for="livro_novo_id">Livro Novo (cliente recebe)</label>
                    <select id="livro_novo_id" name="livro_novo_id"
                        class="{{ $errors->has('livro_novo_id') ? 'is-invalid' : '' }}">
                        <option value="" disabled {{ old('livro_novo_id', $trocaLivro->livro_novo_id ?? '') === '' ? 'selected' : '' }}>Selecione…</option>

                        @if ($editing && $trocaLivro->livroNovo && !$trocaLivro->livroNovo->disponivel)
                            <option value="{{ $trocaLivro->livroNovo->id }}" selected>
                                {{ $trocaLivro->livroNovo->titulo }} — {{ $trocaLivro->livroNovo->autor }} (atual)
                            </option>
                        @endif

                        @foreach ($livrosDisponiveis as $livro)
                            <option value="{{ $livro->id }}"
                                {{ old('livro_novo_id', $trocaLivro->livro_novo_id ?? '') == $livro->id ? 'selected' : '' }}>
                                {{ $livro->titulo }} — {{ $livro->autor }}
                            </option>
                        @endforeach
                    </select>
                    @error('livro_novo_id') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                {{-- Livro Antigo: cliente traz de fora, digitado manualmente --}}
                <div class="form-group">
                    <label for="livro_antigo_titulo">Livro Antigo — Título (cliente entrega)</label>
                    <input type="text" id="livro_antigo_titulo" name="livro_antigo_titulo"
                        value="{{ old('livro_antigo_titulo', $trocaLivro->livroAntigo->titulo ?? '') }}"
                        placeholder="Ex: Harry Potter e a Pedra Filosofal"
                        class="{{ $errors->has('livro_antigo_titulo') ? 'is-invalid' : '' }}">
                    @error('livro_antigo_titulo') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="livro_antigo_autor">Livro Antigo — Autor</label>
                    <input type="text" id="livro_antigo_autor" name="livro_antigo_autor"
                        value="{{ old('livro_antigo_autor', $trocaLivro->livroAntigo->autor ?? '') }}"
                        placeholder="Ex: J.K. Rowling"
                        class="{{ $errors->has('livro_antigo_autor') ? 'is-invalid' : '' }}">
                    @error('livro_antigo_autor') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="section-divider full"><span>Condições</span></div>

                <div class="form-group">
                    <label for="valor_pago">Valor Pago (R$)</label>
                    <input type="number" id="valor_pago" name="valor_pago"
                        value="{{ old('valor_pago', $trocaLivro->valor_pago ?? '') }}"
                        placeholder="0.00" step="0.01" min="0"
                        class="{{ $errors->has('valor_pago') ? 'is-invalid' : '' }}">
                    @error('valor_pago') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status"
                        class="{{ $errors->has('status') ? 'is-invalid' : '' }}">
                        <option value="" disabled {{ old('status', $trocaLivro->status ?? '') === '' ? 'selected' : '' }}>Selecione…</option>
                        @foreach (['pendente' => 'Pendente', 'aprovada' => 'Aprovada', 'recusada' => 'Recusada', 'concluida' => 'Concluída'] as $value => $label)
                            <option value="{{ $value }}"
                                {{ old('status', $trocaLivro->status ?? '') === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('status') <span class="field-error">{{ $message }}</span> @enderror
                </div>

            </div>
        </div>

        <div class="card-footer">
            <a href="{{ route('troca-livros.index') }}" class="btn btn-ghost">Cancelar</a>
            <button type="submit" class="btn btn-primary">
                {{ $editing ? 'Salvar Alterações' : 'Registrar Troca' }}
            </button>
        </div>
    </form>
</div>

@endsection