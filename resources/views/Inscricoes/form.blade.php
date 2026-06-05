@php
    $editing   = isset($inscricao) && $inscricao->exists;
    $isCliente = auth()->check() && auth()->user()->tipo === 'cliente';

    $action = $isCliente
        ? route('cliente.inscricoes.store')
        : ($editing ? route('inscricoes.update', $inscricao) : route('inscricoes.store'));
@endphp

@extends('main')

@section('titulo', $editing ? 'Editar Inscrição · Eclipse Sebo' : 'Nova Inscrição · Eclipse Sebo')

@section('content')

<div class="page-header">
    <p class="tag">Eventos</p>
    <h1>{{ $editing ? 'Editar Inscrição' : 'Nova Inscrição' }}</h1>
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
        @if($editing) @method('PUT') @endif

        <div class="card-body">
            <div class="form-grid">

                <div class="section-divider full"><span>Participante</span></div>

                @if($isCliente)
                    {{-- Cliente: campos ocultos, mostra só o evento --}}
                    <input type="hidden" name="evento_id" value="{{ $evento->id }}">
                    <input type="hidden" name="data_inscricao" value="{{ now()->toDateString() }}">

                    <div class="form-group full">
                        <label>Evento</label>
                        <input type="text" value="{{ $evento->titulo }}" disabled>
                    </div>

                    <div class="form-group">
                        <label>Data</label>
                        <input type="text" value="{{ $evento->data_hora_inicio->format('d/m/Y H:i') }} até {{ $evento->data_hora_fim->format('d/m/Y H:i') }}" disabled>
                    </div>

                    <div class="form-group">
                        <label>Valor do Ingresso</label>
                        <input type="text" value="R$ {{ number_format($evento->valor_ingresso, 2, ',', '.') }}" disabled>
                    </div>

                @else
                    {{-- Admin: selects completos --}}
                    <div class="form-group">
                        <label for="usuario_id">Usuário</label>
                        <select id="usuario_id" name="usuario_id" required
                            class="{{ $errors->has('usuario_id') ? 'is-invalid' : '' }}">
                            <option value="">Selecione…</option>
                            @foreach($usuarios as $usuario)
                                <option value="{{ $usuario->id }}"
                                    {{ old('usuario_id', $inscricao->usuario_id ?? '') == $usuario->id ? 'selected' : '' }}>
                                    {{ $usuario->nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('usuario_id') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="evento_id">Evento</label>
                        <select id="evento_id" name="evento_id" required
                            class="{{ $errors->has('evento_id') ? 'is-invalid' : '' }}">
                            <option value="">Selecione…</option>
                            @foreach($eventos as $evt)
                                <option value="{{ $evt->id }}"
                                    {{ old('evento_id', $inscricao->evento_id ?? $eventoSelecionado ?? '') == $evt->id ? 'selected' : '' }}>
                                    {{ $evt->titulo }}
                                </option>
                            @endforeach
                        </select>
                        @error('evento_id') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="section-divider full"><span>Pagamento & Data</span></div>

                    <div class="form-group">
                        <label for="data_inscricao">Data da Inscrição</label>
                        <input type="date" id="data_inscricao" name="data_inscricao"
                            value="{{ old('data_inscricao', isset($inscricao) ? $inscricao->data_inscricao->format('Y-m-d') : now()->format('Y-m-d')) }}"
                            class="{{ $errors->has('data_inscricao') ? 'is-invalid' : '' }}">
                        @error('data_inscricao') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                @endif

                <div class="section-divider full"><span>Pagamento{{ $isCliente ? '' : ' & Data' }}</span></div>

                <div class="form-group {{ $isCliente ? 'full' : '' }}">
                    <label for="forma_pagamento">Forma de Pagamento</label>
                    <select id="forma_pagamento" name="forma_pagamento" required
                        class="{{ $errors->has('forma_pagamento') ? 'is-invalid' : '' }}">
                        <option value="">Selecione…</option>
                        @foreach(['pix' => 'PIX', 'cartao_credito' => 'Cartão Crédito', 'cartao_debito' => 'Cartão Débito', 'dinheiro' => 'Dinheiro'] as $valor => $label)
                            <option value="{{ $valor }}"
                                {{ old('forma_pagamento', $inscricao->forma_pagamento ?? '') == $valor ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('forma_pagamento') <span class="field-error">{{ $message }}</span> @enderror
                </div>

            </div>
        </div>

        <div class="card-footer">
            <a href="{{ $isCliente ? route('cliente.eventos') : route('inscricoes.index') }}" class="btn btn-ghost">Cancelar</a>
            <button type="submit" class="btn btn-primary">
                {{ $editing ? 'Salvar Alterações' : ($isCliente ? 'Confirmar Inscrição' : 'Cadastrar Inscrição') }}
            </button>
        </div>

    </form>
</div>

@endsection