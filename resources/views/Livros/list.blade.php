@extends('main')

@section('titulo', 'Livros · Eclipse Sebo')

@section('content')

<div class="top-bar">
    <div class="heading">
        <p class="tag">Acervo</p>
        <h1>Livros</h1>
        <p class="subtitle">Gerencie o estoque de livros disponíveis</p>
    </div>
    <a href="{{ route('livros.create') }}" class="btn btn-primary">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Novo Livro
    </a>
</div>

<div class="toolbar">
    <div class="search-wrap">
        <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" class="search-input" id="search-input" placeholder="Buscar por título ou autor…">
    </div>
    <span class="count-badge" id="count-badge">
        {{ $livros->count() }} {{ $livros->count() === 1 ? 'livro' : 'livros' }}
    </span>
</div>

<div class="table-wrap">
    @if ($livros->isEmpty())
        <div class="empty-state">
            <p>Nenhum livro cadastrado ainda.</p>
            <span>Clique em <strong>Novo Livro</strong> para começar.</span>
        </div>
    @else
        <table id="livros-table">
            <thead>
                <tr>
                    <th>Título / Autor</th>
                    <th class="col-editora">Editora</th>
                    <th class="col-genero">Gênero</th>
                    <th>Preço</th>
                    <th class="col-estado">Estado</th>
                    <th>Disponível</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($livros as $livro)
                    <tr data-search="{{ strtolower($livro->titulo . ' ' . $livro->autor) }}">
                        <td class="td-title">
                            <strong>{{ $livro->titulo }}</strong>
                            <small>{{ $livro->autor }}</small>
                        </td>
                        <td class="col-editora">{{ $livro->editora }}</td>
                        <td class="col-genero">{{ $livro->genero }}</td>
                        <td class="td-price">R$ {{ number_format($livro->preco, 2, ',', '.') }}</td>
                        <td class="col-estado">
                            @php
                                $badgeClass = match($livro->estado_conservacao) {
                                    'Novo'    => 'badge-novo',
                                    'Ótimo'   => 'badge-otimo',
                                    'Bom'     => 'badge-bom',
                                    'Regular' => 'badge-regular',
                                    default   => 'badge-ruim',
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $livro->estado_conservacao }}</span>
                        </td>
                        <td>
                            @if ($livro->disponivel)
                                <span class="dot dot-yes">Sim</span>
                            @else
                                <span class="dot dot-no">Não</span>
                            @endif
                        </td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('livros.edit', $livro) }}" class="btn btn-ghost">Editar</a>
                                <form method="POST" action="{{ route('livros.destroy', $livro) }}"
                                      onsubmit="return confirm('Remover \'{{ addslashes($livro->titulo) }}\'?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Remover</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<script>
    const input = document.getElementById('search-input');
    const badge = document.getElementById('count-badge');
    const rows  = document.querySelectorAll('#livros-table tbody tr');

    if (input) {
        input.addEventListener('input', () => {
            const term = input.value.toLowerCase().trim();
            let visible = 0;
            rows.forEach(row => {
                const match = !term || (row.dataset.search || '').includes(term);
                row.style.display = match ? '' : 'none';
                if (match) visible++;
            });
            if (badge) badge.textContent = `${visible} ${visible === 1 ? 'livro' : 'livros'}`;
        });
    }
</script>

@endsection