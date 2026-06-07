@extends('main')

@section('titulo', 'Livros · Eclipse Sebo')

@section('content')

<div class="top-bar">
    <div class="heading">
        <p class="tag">Acervo</p>
        <h1>Livros</h1>
        <p class="subtitle">Gerencie o estoque de livros disponíveis</p>
    </div>

    @if(auth()->user()->tipo === 'adm')
        <a href="{{ route('livros.create') }}" class="btn btn-primary">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Novo Livro
        </a>
    @endif
</div>

<form method="GET" action="{{ route('livros.search') }}" id="search-form">
    <div class="toolbar">
        <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">

            <div class="search-wrap" style="position:relative; display:flex; align-items:center;">
                <svg
                    viewBox="0 0 24 24"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    style="
                        position:absolute;
                        left:10px;
                        width:15px;
                        height:15px;
                        stroke:#999;
                        fill:none;
                        stroke-width:2;
                        pointer-events:none;
                    "
                >
                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>

                <input
                    type="text"
                    name="search"
                    class="search-input"
                    id="search-input"
                    placeholder="Buscar por título ou autor..."
                    value="{{ request('search') }}"
                    autocomplete="off"
                    style="padding-left:34px; padding-right:34px;"
                >

                <button
                    type="button"
                    id="search-clear"
                    title="Limpar busca"
                    style="
                        position:absolute;
                        right:10px;
                        background:none;
                        border:none;
                        cursor:pointer;
                        color:#999;
                        font-size:1.1rem;
                        line-height:1;
                        padding:0;
                        display:{{ request('search') ? 'block' : 'none' }};
                    "
                >×</button>
            </div>

        </div>

        <span class="count-badge">
            {{ $livros->count() }}
            {{ $livros->count() === 1 ? 'livro' : 'livros' }}
        </span>
    </div>
</form>

<div class="table-wrap">
    @if ($livros->isEmpty())

        <div class="empty-state">
            @if(request('search'))
                <p>Nenhum livro encontrado para "<strong>{{ request('search') }}</strong>".</p>
                <a href="{{ route('livros.index') }}" class="btn btn-ghost">Limpar busca</a>
            @else
                <p>Nenhum livro cadastrado ainda.</p>
                @if(auth()->user()->tipo === 'adm')
                    <span>Clique em <strong>Novo Livro</strong> para começar.</span>
                @endif
            @endif
        </div>

    @else

        <table id="livros-table">
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Título / Autor</th>
                    <th class="col-editora">Editora</th>
                    <th class="col-genero">Gênero</th>
                    <th>Preço</th>
                    <th class="col-estado">Estado</th>
                    <th>Disponível</th>

                    @if(auth()->user()->tipo === 'adm')
                        <th>Ações</th>
                    @endif
                </tr>
            </thead>

            <tbody>
                @foreach ($livros as $livro)
                    <tr>
                        <td>
                            <img
                                src="{{ $livro->imagem ? asset('storage/' . $livro->imagem) : asset('images/sem-imagem.png') }}"
                                alt="{{ $livro->titulo }}"
                                style="
                                    width:120px;
                                    height:160px;
                                    object-fit:cover;
                                    border-radius:10px;
                                    border:1px solid #ddd;
                                    box-shadow:0 2px 8px rgba(0,0,0,0.15);
                                "
                            >
                        </td>

                        <td class="td-title">
                            <strong>{{ $livro->titulo }}</strong>
                            <small>{{ $livro->autor }}</small>
                        </td>

                        <td class="col-editora">{{ $livro->editora }}</td>

                        <td class="col-genero">{{ $livro->genero }}</td>

                        <td class="td-price">
                            R$ {{ number_format($livro->preco, 2, ',', '.') }}
                        </td>

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
                            <span class="badge {{ $badgeClass }}">
                                {{ $livro->estado_conservacao }}
                            </span>
                        </td>

                        <td>
                            @if ($livro->disponivel)
                                <span class="dot dot-yes">Sim</span>
                            @else
                                <span class="dot dot-no">Não</span>
                            @endif
                        </td>

                        @if(auth()->user()->tipo === 'adm')
                            <td>
                                <div class="actions">
                                    <a href="{{ route('livros.edit', $livro) }}" class="btn btn-ghost">
                                        Editar
                                    </a>

                                    <form method="POST"
                                          action="{{ route('livros.destroy', $livro) }}"
                                          onsubmit="return confirm('Remover \'{{ addslashes($livro->titulo) }}\'?')">
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
document.addEventListener('DOMContentLoaded', function () {
    const input    = document.getElementById('search-input');
    const clearBtn = document.getElementById('search-clear');
    const form     = document.getElementById('search-form');

    input.addEventListener('input', function () {
        clearBtn.style.display = input.value.length > 0 ? 'block' : 'none';
    });

    input.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            form.submit();
        }
    });

    clearBtn.addEventListener('click', function () {
        window.location.href = "{{ route('livros.index') }}";
    });
});
</script>

@endsection