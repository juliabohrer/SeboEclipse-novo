@extends('main')

@section('titulo', 'Inscrições · Eclipse Sebo')

@section('content')

@php $isAdm = auth()->check() && auth()->user()->tipo === 'adm'; @endphp

<div class="top-bar">
    <div class="heading">
        <p class="tag">Eventos</p>
        <h1>Inscrições</h1>
        <p class="subtitle">
            @isset($evento)
                Inscrições do evento: <strong>{{ $evento->titulo }}</strong>
            @else
                Gerencie as inscrições dos eventos
            @endisset
        </p>
    </div>

    @isset($evento)
        <a href="{{ route('eventos.index') }}" class="btn btn-ghost">← Voltar aos Eventos</a>
    @endisset

    @if($isAdm)
        <a href="{{ route('inscricoes.create') }}" class="btn btn-primary">Nova Inscrição</a>
    @endif
</div>

<div class="toolbar">
    <div class="search-wrap">
        <input type="text" class="search-input" id="search-input" placeholder="Buscar usuário ou evento…">
    </div>
    <span class="count-badge" id="count-badge">
        {{ $inscricoes->count() }} {{ $inscricoes->count() === 1 ? 'inscrição' : 'inscrições' }}
    </span>
</div>

<div class="table-wrap">

    @if($inscricoes->isEmpty())
        <div class="empty-state">
            <p>Nenhuma inscrição cadastrada.</p>
        </div>
    @else
        <table id="inscricoes-table">
            <thead>
                <tr>
                    <th>Usuário</th>
                    <th>Evento</th>
                    <th>Data</th>
                    <th>Pagamento</th>
                    <th>Código</th>
                    @if($isAdm)
                        <th>Ações</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($inscricoes as $inscricao)
                    <tr data-search="{{ strtolower($inscricao->usuario->nome . ' ' . $inscricao->evento->titulo) }}">

                        <td class="td-title">
                            <strong>{{ $inscricao->usuario->nome }}</strong>
                            <small>ID: {{ $inscricao->usuario->id }}</small>
                        </td>

                        <td>{{ $inscricao->evento->titulo }}</td>

                        <td>{{ $inscricao->data_inscricao->format('d/m/Y') }}</td>

                        <td>
                            <span class="badge badge-bom">
                                {{ match($inscricao->forma_pagamento) {
                                    'pix'            => 'PIX',
                                    'cartao_credito' => 'Cartão Crédito',
                                    'cartao_debito'  => 'Cartão Débito',
                                    default          => 'Dinheiro'
                                } }}
                            </span>
                        </td>

                        <td><code>{{ $inscricao->codigo_inscricao }}</code></td>

                        @if($isAdm)
                            <td>
                                <div class="actions">
                                    <a href="{{ route('inscricoes.edit', $inscricao) }}" class="btn btn-ghost">Editar</a>
                                    <form method="POST" action="{{ route('inscricoes.destroy', $inscricao) }}"
                                          onsubmit="return confirm('Excluir inscrição?')">
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
    const rows  = document.querySelectorAll('#inscricoes-table tbody tr');

    if (input) {
        input.addEventListener('input', () => {
            const term = input.value.toLowerCase().trim();
            let visible = 0;
            rows.forEach(row => {
                const match = !term || (row.dataset.search || '').includes(term);
                row.style.display = match ? '' : 'none';
                if (match) visible++;
            });
            badge.textContent = `${visible} ${visible === 1 ? 'inscrição' : 'inscrições'}`;
        });
    }
</script>

@endsection