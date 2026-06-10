@extends('main')

@section('titulo', 'Trocas · Eclipse Sebo')

@section('content')

<div class="top-bar">
    <div class="heading">
        <p class="tag">Acervo</p>
        <h1>Trocas de Livros</h1>
        <p class="subtitle">Gerencie as trocas registradas no sistema</p>
    </div>
    @if(auth()->user()->tipo === 'adm')
        <a href="{{ route('troca-livros.create') }}" class="btn btn-primary">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Nova Troca
        </a>
    @endif
</div>

<div class="toolbar">
<<<<<<< HEAD
    <form method="GET" action="{{ route('troca-livros.search') }}" class="search-wrap" style="max-width: 340px;">
=======
    <div class="search-wrap" style="max-width: 340px;">
>>>>>>> 6956ba793a09afc4d1878caad82cbcc5560616a6
        <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" name="search" class="search-input" placeholder="Buscar por livro ou usuário…"
               value="{{ request('search') }}" autocomplete="off">
    </form>
    <span class="count-badge">
        {{ $trocas->count() }} {{ $trocas->count() === 1 ? 'troca' : 'trocas' }}
    </span>
</div>

<div class="table-wrap">
    @if ($trocas->isEmpty())
        <div class="empty-state">
            <p>Nenhuma troca registrada ainda.</p>
            @if(auth()->user()->tipo === 'adm')
                <span>Clique em <strong>Nova Troca</strong> para começar.</span>
            @endif
        </div>
    @else
        <table id="trocas-table">
            <thead>
                <tr>
                    <th>Usuário</th>
                    <th>Livro Novo</th>
                    <th class="col-antigo">Livro Antigo</th>
                    <th>Valor Pago</th>
                    <th>Status</th>
                    @if(auth()->user()->tipo === 'adm')
                        <th>Ações</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($trocas as $troca)
                    <tr>
                        <td class="td-nome">
                            <strong>{{ optional($troca->usuario)->nome ?? '—' }}</strong>
                        </td>
                        <td class="td-title">
                            <strong>{{ optional($troca->livroNovo)->titulo ?? '—' }}</strong>
                            <small>{{ optional($troca->livroNovo)->autor ?? '' }}</small>
                        </td>
                        <td class="col-antigo td-title">
                            <strong>{{ optional($troca->livroAntigo)->titulo ?? '—' }}</strong>
                            <small>{{ optional($troca->livroAntigo)->autor ?? '' }}</small>
                        </td>
                        <td class="td-price">R$ {{ number_format($troca->valor_pago, 2, ',', '.') }}</td>
                        <td>
                            @php
                                $statusClass = match($troca->status) {
                                    'pendente'  => 'badge-regular',
                                    'aprovada'  => 'badge-bom',
                                    'concluida' => 'badge-novo',
                                    default     => 'badge-ruim',
                                };
                            @endphp
                            <span class="badge {{ $statusClass }}">{{ ucfirst($troca->status) }}</span>
                        </td>
                        @if(auth()->user()->tipo === 'adm')
                            <td>
                                <div class="actions">
                                    <a href="{{ route('troca-livros.edit', $troca) }}" class="btn btn-ghost">Editar</a>
                                    <form method="POST" action="{{ route('troca-livros.destroy', $troca) }}"
                                          onsubmit="return confirm('Remover esta troca?')">
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

@endsection