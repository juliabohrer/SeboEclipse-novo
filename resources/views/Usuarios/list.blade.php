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
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Novo Usuário
        </a>
    @endif
</div>

<div class="toolbar">
    <div class="search-wrap">
        <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" class="search-input" id="search-input" placeholder="Buscar por nome ou e-mail…">
    </div>
    <span class="count-badge" id="count-badge">
        {{ $usuarios->count() }} {{ $usuarios->count() === 1 ? 'usuário' : 'usuários' }}
    </span>
</div>

<div class="table-wrap">
    @if ($usuarios->isEmpty())
        <div class="empty-state">
            <p>Nenhum usuário cadastrado ainda.</p>
            @if (auth()->user()->tipo === 'adm')
                <span>Clique em <strong>Novo Usuário</strong> para começar.</span>
            @endif
        </div>
    @else
        <table id="usuarios-table">
            <thead>
                <tr>
                    <th>Nome / E-mail</th>
                    <th class="col-cpf">CPF</th>
                    <th class="col-telefone">Telefone</th>
                    <th class="col-endereco">Endereço</th>
                    <th>Tipo</th>
                    @if (auth()->user()->tipo === 'adm')
                        <th>Ações</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario)
                    <tr data-search="{{ strtolower($usuario->nome . ' ' . $usuario->email) }}">
                        <td class="td-nome">
                            <strong>{{ $usuario->nome }}</strong>
                            <small>{{ $usuario->email }}</small>
                        </td>
                        <td class="col-cpf">{{ $usuario->cpf }}</td>
                        <td class="col-telefone">{{ $usuario->telefone }}</td>
                        <td class="col-endereco">{{ $usuario->endereco }}</td>
                        <td>
                            <span class="badge badge-{{ $usuario->tipo }}">
                                {{ ucfirst($usuario->tipo) }}
                            </span>
                        </td>
                        @if (auth()->user()->tipo === 'adm')
                            <td>
                                <div class="actions">
                                    <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-ghost">Editar</a>
                                    <form method="POST" action="{{ route('usuarios.destroy', $usuario) }}"
                                          onsubmit="return confirm('Remover \'{{ addslashes($usuario->nome) }}\'?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Remover</button>
                                    </form>
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<script>
    const input = document.getElementById('search-input');
    const badge = document.getElementById('count-badge');
    const rows  = document.querySelectorAll('#usuarios-table tbody tr');

    if (input) {
        input.addEventListener('input', () => {
            const term = input.value.toLowerCase().trim();
            let visible = 0;
            rows.forEach(row => {
                const match = !term || (row.dataset.search || '').includes(term);
                row.style.display = match ? '' : 'none';
                if (match) visible++;
            });
            if (badge) badge.textContent = `${visible} ${visible === 1 ? 'usuário' : 'usuários'}`;
        });
    }
</script>

@endsection