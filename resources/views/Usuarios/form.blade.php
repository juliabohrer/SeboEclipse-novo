@php
    $editing  = isset($usuario) && $usuario->exists;
    $isAdm    = auth()->check() && auth()->user()->tipo === 'adm';
    $isPerfil = auth()->check() && auth()->user()->tipo === 'cliente' && $editing;

    if ($editing && $isAdm) {
        $action = route('usuarios.update', $usuario);
    } elseif ($isPerfil) {
        $action = route('cliente.perfil.update');
    } else {
        $action = route('cadastro.store');
    }
@endphp

@extends('main')

@section('titulo', $editing ? 'Editar Usuário · Eclipse Sebo' : 'Novo Usuário · Eclipse Sebo')

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
    <h1>{{ $editing ? 'Editar Usuário' : 'Cadastrar Usuário' }}</h1>
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
    <form method="POST" action="{{ $action }}" enctype="multipart/form-data">
        @csrf
        @if($editing && $isAdm) @method('PUT') @endif
        @if($isPerfil) @method('PUT') @endif

        <div class="card-body">
            <div class="form-grid">

                <div class="section-divider full"><span>Dados Pessoais</span></div>

                {{-- Foto de perfil --}}
                <div class="form-group full">
                    <label for="imagem">Foto de Perfil</label>

                    <input
                        type="file"
                        id="imagem"
                        name="imagem"
                        accept="image/png,image/jpeg,image/jpg,image/webp"
                    >

                    <div style="margin-top: 10px;">
                        <img
                            src="{{ $editing ? $usuario->imagem_url : asset('images/sem-imagem.png') }}"
                            alt="Foto do usuário"
                            width="100"
                            style="border-radius:50%; border:1px solid #ddd; object-fit:cover; aspect-ratio:1/1;"
                        >
                    </div>

                    @error('imagem')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group full">
                    <label for="nome">Nome Completo</label>
                    <input type="text" id="nome" name="nome"
                        value="{{ old('nome', $usuario->nome ?? '') }}"
                        placeholder="Ex.: João da Silva"
                        class="{{ $errors->has('nome') ? 'is-invalid' : '' }}">
                    @error('nome') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="data_nascimento">Data de Nascimento</label>
                    <input type="date" id="data_nascimento" name="data_nascimento"
                        value="{{ old('data_nascimento', isset($usuario) ? \Carbon\Carbon::parse($usuario->data_nascimento)->format('Y-m-d') : '') }}"
                        class="{{ $errors->has('data_nascimento') ? 'is-invalid' : '' }}">
                    @error('data_nascimento') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="cpf">CPF</label>
                    <input type="text" id="cpf" name="cpf"
                        value="{{ old('cpf', $usuario->cpf ?? '') }}"
                        placeholder="000.000.000-00"
                        class="{{ $errors->has('cpf') ? 'is-invalid' : '' }}">
                    @error('cpf') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group full">
                    <label for="endereco">Endereço</label>
                    <input type="text" id="endereco" name="endereco"
                        value="{{ old('endereco', $usuario->endereco ?? '') }}"
                        placeholder="Ex.: Rua das Flores, 123 — Centro"
                        class="{{ $errors->has('endereco') ? 'is-invalid' : '' }}">
                    @error('endereco') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <input type="text" id="telefone" name="telefone"
                        value="{{ old('telefone', $usuario->telefone ?? '') }}"
                        placeholder="(00) 00000-0000"
                        class="{{ $errors->has('telefone') ? 'is-invalid' : '' }}">
                    @error('telefone') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                {{-- Campo tipo: só aparece para o adm --}}
                @if ($isAdm)
                    <div class="form-group">
                        <label for="tipo">Tipo de Usuário</label>
                        <select id="tipo" name="tipo"
                            class="{{ $errors->has('tipo') ? 'is-invalid' : '' }}">
                            <option value="" disabled {{ old('tipo', $usuario->tipo ?? '') === '' ? 'selected' : '' }}>Selecione…</option>
                            @foreach (['adm' => 'Administrador', 'cliente' => 'Cliente'] as $value => $label)
                                <option value="{{ $value }}"
                                    {{ old('tipo', $usuario->tipo ?? '') === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('tipo') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                @endif

                <div class="section-divider full"><span>Acesso</span></div>

                <div class="form-group full">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email"
                        value="{{ old('email', $usuario->email ?? '') }}"
                        placeholder="exemplo@email.com"
                        class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                    @error('email') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="senha">{{ $editing ? 'Nova Senha' : 'Senha' }}</label>
                    <input type="password" id="senha" name="senha"
                        placeholder="{{ $editing ? 'Deixe em branco para manter' : 'Mínimo 6 caracteres' }}"
                        class="{{ $errors->has('senha') ? 'is-invalid' : '' }}">
                    @error('senha')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                    @if ($editing && !$errors->has('senha'))
                        <span class="field-hint">Deixe em branco para não alterar</span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="senha_confirmation">Confirmar Senha</label>
                    <input type="password" id="senha_confirmation" name="senha_confirmation"
                        placeholder="Repita a senha">
                </div>

            </div>
        </div>

        <div class="card-footer">
            @if ($isAdm)
                <a href="{{ route('usuarios.index') }}" class="btn btn-ghost">Cancelar</a>
            @elseif (auth()->check())
                <a href="{{ route('cliente.perfil') }}" class="btn btn-ghost">Cancelar</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-ghost">Voltar ao Login</a>
            @endif
            <button type="submit" class="btn btn-primary">
                {{ $editing ? 'Salvar Alterações' : 'Cadastrar Usuário' }}
            </button>
        </div>

    </form>
</div>

@endsection