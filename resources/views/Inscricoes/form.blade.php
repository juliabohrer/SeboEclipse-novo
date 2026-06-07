@php
    $editing = isset($inscricao) && $inscricao->id;
    $action  = $editing
        ? route('inscricoes.update', $inscricao)
        : route('inscricoes.store');
@endphp

@extends('main')

@section('titulo', $editing ? 'Editar Inscrição · Eclipse Sebo' : 'Nova Inscrição · Eclipse Sebo')

@section('content')

<div class="page-header">
    <p class="tag">{{ $editing ? 'Atualizar inscrição' : 'Nova inscrição' }}</p>
    <h1>{{ $editing ? 'Editar Inscrição' : 'Nova Inscrição' }}</h1>
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

                <div class="form-group">
                    <label for="usuario_id">Usuário</label>
                    <select id="usuario_id" name="usuario_id"
                        class="{{ $errors->has('usuario_id') ? 'is-invalid' : '' }}">
                        <option value="" disabled {{ old('usuario_id', $inscricao->usuario_id ?? '') === '' ? 'selected' : '' }}>Selecione um usuário…</option>
                        @foreach ($usuarios as $usuarioOpcao)
                            <option value="{{ $usuarioOpcao->id }}"
                                {{ old('usuario_id', $inscricao->usuario_id ?? '') == $usuarioOpcao->id ? 'selected' : '' }}>
                                {{ $usuarioOpcao->nome }}
                            </option>
                        @endforeach
                    </select>
                    @error('usuario_id') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="evento_id">Evento</label>
                    <select id="evento_id" name="evento_id"
                        class="{{ $errors->has('evento_id') ? 'is-invalid' : '' }}">
                        <option value="" disabled {{ old('evento_id', $inscricao->evento_id ?? $eventoSelecionado ?? '') === '' ? 'selected' : '' }}>Selecione um evento…</option>
                        @foreach ($eventos as $eventoOpcao)
                            <option value="{{ $eventoOpcao->id }}"
                                {{ old('evento_id', $inscricao->evento_id ?? $eventoSelecionado ?? '') == $eventoOpcao->id ? 'selected' : '' }}>
                                {{ $eventoOpcao->titulo }} — {{ $eventoOpcao->data_hora_inicio->format('d/m/Y') }}
                            </option>
                        @endforeach
                    </select>
                    @error('evento_id') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="section-divider full"><span>Dados da Inscrição</span></div>

                <div class="form-group">
                    <label for="data_inscricao">Data da Inscrição</label>
                    <input
                        type="date"
                        id="data_inscricao"
                        name="data_inscricao"
                        value="{{ old('data_inscricao', isset($inscricao) && $inscricao->data_inscricao ? $inscricao->data_inscricao->format('Y-m-d') : date('Y-m-d')) }}"
                        class="{{ $errors->has('data_inscricao') ? 'is-invalid' : '' }}"
                    >
                    @error('data_inscricao') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="forma_pagamento">Forma de Pagamento</label>
                    <select id="forma_pagamento" name="forma_pagamento"
                        class="{{ $errors->has('forma_pagamento') ? 'is-invalid' : '' }}">
                        <option value="" disabled {{ old('forma_pagamento', $inscricao->forma_pagamento ?? '') === '' ? 'selected' : '' }}>Selecione…</option>
                        @foreach ([
                            'pix'            => 'Pix',
                            'cartao_credito' => 'Cartão de Crédito',
                            'cartao_debito'  => 'Cartão de Débito',
                            'dinheiro'       => 'Dinheiro',
                        ] as $val => $label)
                            <option value="{{ $val }}"
                                {{ old('forma_pagamento', $inscricao->forma_pagamento ?? '') === $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('forma_pagamento') <span class="field-error">{{ $message }}</span> @enderror
                </div>

            </div>
        </div>

        <div class="card-footer">
            <a href="{{ route('inscricoes.index') }}" class="btn btn-ghost">Cancelar</a>
            <button type="submit" class="btn btn-primary">
                {{ $editing ? 'Salvar Alterações' : 'Registrar Inscrição' }}
            </button>
        </div>
    </form>
</div>

@endsection