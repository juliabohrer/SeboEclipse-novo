@extends('main')

@section('titulo', 'Usuários · Eclipse Sebo')

@section('content')


<div class="top-bar">
    <div class="heading">
        <p class="tag">Gestão</p>
        <h1>Usuários</h1>
        <p class="subtitle">Gerencie os usuários cadastrados no sistema</p>
    </div>
    @if (auth()->user()->tipo === 'adm')
        <a href="{{ route('usuarios.create') }}" class="btn btn-primary">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Novo Usuário
        </a>
    @endif
</div>

<div class="toolbar">
    <div class="search-wrap">
        <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"/>
            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <input type="text" class="search-input" id="search-input" placeholder="Buscar por nome ou e-mail…">
    </div>
    <span class="count-badge" id="count-badge">
        {{ $usuarios->count() }} {{ $usuarios->count() === 1 ? 'usuário' : 'usuários' }}
    </span>
</div>

@if ($usuarios->isEmpty())
    <div class="empty-state">
        <p>Nenhum usuário cadastrado ainda.</p>
        @if (auth()->user()->tipo === 'adm')
            <span>Clique em <strong>Novo Usuário</strong> para começar.</span>
        @endif
    </div>
@else
    <div class="usuarios-grid" id="usuarios-grid">
        @foreach ($usuarios as $usuario)
            @php
                $initials = collect(explode(' ', $usuario->nome))
                    ->filter()
                    ->map(fn($p) => strtoupper($p[0]))
                    ->take(2)
                    ->implode('');
            @endphp

            <div class="usuario-card" data-search="{{ strtolower($usuario->nome . ' ' . $usuario->email) }}">

                {{-- Foto --}}
                <div class="usuario-card__cover">
                    @if ($usuario->imagem)
                        <img src="{{ $usuario->imagem_url }}" alt="Foto de {{ $usuario->nome }}">
                    @else
                        <div class="usuario-card__initials">{{ $initials }}</div>
                    @endif

                    <span class="usuario-card__badge badge badge-{{ $usuario->tipo }}">
                        {{ ucfirst($usuario->tipo) }}
                    </span>
                </div>

                {{-- Informações --}}
                <div class="usuario-card__body">

                    <p class="usuario-card__nome">{{ $usuario->nome }}</p>
                    <p class="usuario-card__email">{{ $usuario->email }}</p>

                    <div class="usuario-card__divider"></div>

                    <ul class="usuario-card__info">
                        <li>
                            <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            {{ \Carbon\Carbon::parse($usuario->data_nascimento)->format('d/m/Y') }}
                        </li>
                        <li>
                            <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81 19.79 19.79 0 01.07 1.18 2 2 0 012 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                            {{ $usuario->telefone }}
                        </li>
                        <li>
                            <svg viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1116 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            {{ $usuario->endereco }}
                        </li>
                        <li>
                            <svg viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                            {{ $usuario->cpf }}
                        </li>
                    </ul>

                </div>

                {{-- Ações --}}
                @if (auth()->user()->tipo === 'adm')
                    <div class="usuario-card__footer">
                        <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-ghost">Editar</a>
                        <form method="POST" action="{{ route('usuarios.destroy', $usuario) }}"
                              onsubmit="return confirm('Remover \'{{ addslashes($usuario->nome) }}\'?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Remover</button>
                        </form>
                    </div>
                @endif

            </div>
        @endforeach
    </div>
@endif

<script>
    const input = document.getElementById('search-input');
    const badge = document.getElementById('count-badge');
    const cards = document.querySelectorAll('.usuario-card');

    if (input) {
        input.addEventListener('input', () => {
            const term = input.value.toLowerCase().trim();
            let visible = 0;
            cards.forEach(card => {
                const match = !term || (card.dataset.search || '').includes(term);
                card.style.display = match ? '' : 'none';
                if (match) visible++;
            });
            if (badge) badge.textContent = `${visible} ${visible === 1 ? 'usuário' : 'usuários'}`;
        });
    }
</script>

@endsection