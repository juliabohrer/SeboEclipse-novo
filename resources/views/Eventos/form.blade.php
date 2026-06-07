@php
    $editing = isset($evento) && $evento->exists;

    $action = $editing
        ? route('eventos.update', $evento)
        : route('eventos.store');
@endphp

@extends('main')

@section(
    'titulo',
    $editing ? 'Editar Evento · Eclipse Sebo' : 'Novo Evento · Eclipse Sebo'
)

@section('content')

<div class="page-header">
    <p class="tag">{{ $editing ? 'Atualizar evento' : 'Novo evento' }}</p>
    <h1>{{ $editing ? 'Editar Evento' : 'Cadastrar Evento' }}</h1>
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

    <form method="POST" action="{{ $action }}" enctype="multipart/form-data">
        @csrf
        @if ($editing)
            @method('PUT')
        @endif

        <div class="card-body">

            <div class="form-grid">

                {{-- Capa --}}
                <div class="form-group full">
                    <label for="imagem">Capa do Evento</label>

                    <input
                        type="file"
                        id="imagem"
                        name="imagem"
                        accept="image/png,image/jpeg,image/jpg,image/webp"
                    >

                    <div style="margin-top:10px;">
                        <img
                            src="{{ $editing && !empty($evento->imagem)
                                ? asset('storage/' . $evento->imagem)
                                : asset('images/sem-imagem.png') }}"
                            alt="Capa do evento"
                            width="150"
                            style="border-radius:8px; border:1px solid #ddd;"
                        >
                    </div>

                    @error('imagem')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="section-divider full">
                    <span>Informações do Evento</span>
                </div>

                {{-- Organizador --}}
                <div class="form-group">
                    <label for="usuario_id">Organizador</label>

                    <select
                        id="usuario_id"
                        name="usuario_id"
                        class="{{ $errors->has('usuario_id') ? 'is-invalid' : '' }}"
                    >
                        <option value="">Selecione…</option>

                        @foreach ($usuarios as $usuario)
                            <option
                                value="{{ $usuario->id }}"
                                {{ old('usuario_id', $evento->usuario_id ?? '') == $usuario->id ? 'selected' : '' }}
                            >
                                {{ $usuario->nome }}
                            </option>
                        @endforeach
                    </select>

                    @error('usuario_id')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Título --}}
                <div class="form-group">
                    <label for="titulo">Título</label>

                    <input
                        type="text"
                        id="titulo"
                        name="titulo"
                        value="{{ old('titulo', $evento->titulo ?? '') }}"
                        placeholder="Ex.: Feira de Troca de Livros"
                        class="{{ $errors->has('titulo') ? 'is-invalid' : '' }}"
                    >

                    @error('titulo')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Descrição --}}
                <div class="form-group full">
                    <label for="descricao">Descrição</label>

                    <textarea
                        id="descricao"
                        name="descricao"
                        rows="5"
                        placeholder="Descreva o evento..."
                        class="{{ $errors->has('descricao') ? 'is-invalid' : '' }}"
                    >{{ old('descricao', $evento->descricao ?? '') }}</textarea>

                    @error('descricao')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="section-divider full">
                    <span>Datas & Valores</span>
                </div>

                {{-- Data Início --}}
                <div class="form-group">
                    <label for="data_hora_inicio">Data/Hora Início</label>

                    <input
                        type="datetime-local"
                        id="data_hora_inicio"
                        name="data_hora_inicio"
                        value="{{ old('data_hora_inicio', isset($evento) ? $evento->data_hora_inicio->format('Y-m-d\TH:i') : '') }}"
                        class="{{ $errors->has('data_hora_inicio') ? 'is-invalid' : '' }}"
                    >

                    @error('data_hora_inicio')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Data Fim --}}
                <div class="form-group">
                    <label for="data_hora_fim">Data/Hora Fim</label>

                    <input
                        type="datetime-local"
                        id="data_hora_fim"
                        name="data_hora_fim"
                        value="{{ old('data_hora_fim', isset($evento) ? $evento->data_hora_fim->format('Y-m-d\TH:i') : '') }}"
                        class="{{ $errors->has('data_hora_fim') ? 'is-invalid' : '' }}"
                    >

                    @error('data_hora_fim')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Limite de Pessoas --}}
                <div class="form-group">
                    <label for="limite_pessoas">Limite de Pessoas</label>

                    <input
                        type="number"
                        id="limite_pessoas"
                        name="limite_pessoas"
                        min="1"
                        value="{{ old('limite_pessoas', $evento->limite_pessoas ?? '') }}"
                        class="{{ $errors->has('limite_pessoas') ? 'is-invalid' : '' }}"
                    >

                    @error('limite_pessoas')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Valor do Ingresso --}}
                <div class="form-group">
                    <label for="valor_ingresso">Valor do Ingresso (R$)</label>

                    <input
                        type="number"
                        id="valor_ingresso"
                        name="valor_ingresso"
                        step="0.01"
                        min="0"
                        value="{{ old('valor_ingresso', $evento->valor_ingresso ?? '') }}"
                        class="{{ $errors->has('valor_ingresso') ? 'is-invalid' : '' }}"
                    >

                    @error('valor_ingresso')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

            </div>

        </div>

        <div class="card-footer">
            <a href="{{ route('eventos.index') }}" class="btn btn-ghost">Cancelar</a>
            <button type="submit" class="btn btn-primary">
                {{ $editing ? 'Salvar Alterações' : 'Cadastrar Evento' }}
            </button>
        </div>

    </form>

</div>

@endsection