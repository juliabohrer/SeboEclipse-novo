@extends('main')

@section('titulo', 'Eventos · Eclipse Sebo')

@section('content')

@php $isAdm = auth()->check() && auth()->user()->tipo === 'adm'; @endphp

<div class="top-bar">
    <div class="heading">
        <p class="tag">Eventos</p>
        <h1>Eventos</h1>
        <p class="subtitle">
            {{ $isAdm ? 'Gerencie eventos e inscrições' : 'Confira os eventos disponíveis e inscreva-se' }}
        </p>
    </div>

    @if($isAdm)
        <a href="{{ route('eventos.create') }}" class="btn btn-primary">
            Novo Evento
        </a>
    @endif
</div>

@if($isAdm)
<form method="GET" action="{{ route('eventos.search') }}" id="search-form">
@else
<form method="GET" action="{{ route('cliente.eventos') }}" id="search-form">
@endif
    <div class="toolbar">
        <div class="search-wrap" style="max-width:340px;">
            <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/>
                <line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>

            <input
                type="text"
                name="search"
                class="search-input"
                id="search-input"
                placeholder="Buscar por título ou organizador..."
                value="{{ request('search') }}"
                autocomplete="off"
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

        <span class="count-badge">
            {{ $eventos->count() }}
            {{ $eventos->count() === 1 ? 'evento' : 'eventos' }}
        </span>
    </div>
</form>

<div class="table-wrap" style="overflow-x: auto;">

    @if ($eventos->isEmpty())
        <div class="empty-state">
            @if(request('search'))
                <p>Nenhum evento encontrado para "<strong>{{ request('search') }}</strong>".</p>
                <a href="{{ $isAdm ? route('eventos.index') : route('cliente.eventos') }}" class="btn btn-ghost">Limpar busca</a>
            @else
                <p>Nenhum evento cadastrado.</p>
            @endif
        </div>

    @else

        <table id="eventos-table" style="width:100%; table-layout:auto; min-width:960px;">

            <thead>
                <tr>
                    <th style="width:140px;">Capa</th>
                    <th>Evento</th>
                    <th style="width:140px;">Organizador</th>
                    <th style="width:110px;">Data</th>
                    <th style="width:130px;">Inscrições</th>
                    <th style="width:100px;">Ingresso</th>
                    <th style="width:300px; text-align:right;">Ações</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($eventos as $evento)

                    @php
                        $totalInscritos = $evento->inscricoes->count();
                        $vagasRestantes = $evento->limite_pessoas - $totalInscritos;

                        $jaInscrito = auth()->check()
                            && $evento->inscricoes
                                    ->where('usuario_id', auth()->user()->id)
                                    ->count() > 0;

                        $minhaInscricao = $jaInscrito
                            ? $evento->inscricoes->firstWhere('usuario_id', auth()->user()->id)
                            : null;
                    @endphp

                    <tr>
                        <td>
                            <img
                                src="{{ !empty($evento->imagem) ? asset('storage/' . $evento->imagem) : asset('images/sem-imagem.png') }}"
                                alt="Capa do Evento"
                                width="120"
                                height="160"
                                style="object-fit:cover; border-radius:10px; border:1px solid #ddd;"
                            >
                        </td>

                        <td class="td-title">
                            <strong>{{ $evento->titulo }}</strong>
                            <small>
                                {{ $evento->data_hora_inicio->format('d/m/Y H:i') }}
                                até
                                {{ $evento->data_hora_fim->format('d/m/Y H:i') }}
                            </small>
                        </td>

                        <td>{{ $evento->usuario->nome }}</td>

                        <td>{{ $evento->data_hora_inicio->format('d/m/Y') }}</td>

                        <td>
                            <div style="margin-bottom:6px;">
                                <strong>{{ $totalInscritos }}</strong> / {{ $evento->limite_pessoas }} vagas
                            </div>
                            <small style="opacity:.7;">{{ $vagasRestantes }} vagas restantes</small>
                        </td>

                        <td class="td-price">
                            R$ {{ number_format($evento->valor_ingresso, 2, ',', '.') }}
                        </td>

                        <td>
                            <div class="actions" style="display:flex; gap:6px; flex-wrap:nowrap; justify-content:flex-end; align-items:center;">

                                @if($isAdm)
                                    <a href="{{ route('inscricoes.porEvento', $evento) }}" class="btn btn-ghost">
                                        Ver Inscrições
                                    </a>
                                    <a href="{{ route('eventos.edit', $evento) }}" class="btn btn-ghost">
                                        Editar
                                    </a>
                                    <a href="{{ route('inscricoes.create', ['evento_id' => $evento->id]) }}" class="btn btn-primary">
                                        Inscrever
                                    </a>
                                    <form method="POST"
                                          action="{{ route('eventos.destroy', $evento) }}"
                                          onsubmit="return confirm('Remover evento?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Remover</button>
                                    </form>

                                @else
                                    @if($jaInscrito)
                                        <span class="badge badge-otimo">Inscrito</span>
                                        @if($minhaInscricao)
                                            <small style="display:block; margin-top:4px; opacity:.7;">
                                                Código: <code>{{ $minhaInscricao->codigo_inscricao }}</code>
                                            </small>
                                        @endif
                                    @elseif($vagasRestantes <= 0)
                                        <span class="badge badge-ruim">Lotado</span>
                                    @else
                                        <a href="{{ route('cliente.inscricoes.form', $evento) }}" class="btn btn-primary">
                                            Inscrever-se
                                        </a>
                                    @endif
                                @endif

                            </div>
                        </td>
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
        window.location.href = "{{ $isAdm ? route('eventos.index') : route('cliente.eventos') }}";
    });
});
</script>

@endsection