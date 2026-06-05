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
        <a href="{{ route('eventos.create') }}" class="btn btn-primary">Novo Evento</a>
    @endif
</div>

<div class="toolbar">
    <div class="search-wrap">
        <input type="text" class="search-input" id="search-input" placeholder="Buscar evento…">
    </div>
    <span class="count-badge" id="count-badge">
        {{ $eventos->count() }} {{ $eventos->count() === 1 ? 'evento' : 'eventos' }}
    </span>
</div>

<div class="table-wrap">

    @if ($eventos->isEmpty())
        <div class="empty-state">
            <p>Nenhum evento cadastrado.</p>
        </div>
    @else
        <table id="eventos-table">
            <thead>
                <tr>
                    <th>Evento</th>
                    <th>Organizador</th>
                    <th>Data</th>
                    <th>Inscrições</th>
                    <th>Ingresso</th>
                    <th style="text-align:right">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($eventos as $evento)
                    @php
                        $totalInscritos = $evento->inscricoes->count();
                        $vagasRestantes = $evento->limite_pessoas - $totalInscritos;
                        $jaInscrito     = auth()->check()
                            && $evento->inscricoes->where('usuario_id', auth()->user()->id)->count() > 0;
                        $minhaInscricao = $jaInscrito
                            ? $evento->inscricoes->firstWhere('usuario_id', auth()->user()->id)
                            : null;
                    @endphp

                    <tr data-search="{{ strtolower($evento->titulo . ' ' . $evento->usuario->nome) }}">

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
                            <div style="margin-bottom:6px">
                                <strong>{{ $totalInscritos }}</strong> / {{ $evento->limite_pessoas }} vagas
                            </div>
                            <small style="opacity:.7">{{ $vagasRestantes }} vagas restantes</small>
                        </td>

                        <td class="td-price">
                            R$ {{ number_format($evento->valor_ingresso, 2, ',', '.') }}
                        </td>

                        <td>
                            <div class="actions">

                                @if($isAdm)
                                    <a href="{{ route('inscricoes.porEvento', $evento) }}" class="btn btn-ghost">Ver Inscrições</a>
                                    <a href="{{ route('eventos.edit', $evento) }}" class="btn btn-ghost">Editar</a>
                                    <a href="{{ route('inscricoes.create', ['evento_id' => $evento->id]) }}" class="btn btn-primary">Inscrever</a>
                                    <form method="POST" action="{{ route('eventos.destroy', $evento) }}"
                                          onsubmit="return confirm('Remover evento?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Remover</button>
                                    </form>

                                @else
                                    @if($jaInscrito)
                                        <span class="badge badge-otimo">Inscrito</span>
                                        @if($minhaInscricao)
                                            <small style="display:block; margin-top:4px; opacity:.7">
                                                Código: <code>{{ $minhaInscricao->codigo_inscricao }}</code>
                                            </small>
                                        @endif
                                    @elseif($vagasRestantes <= 0)
                                        <span class="badge badge-ruim">Lotado</span>
                                    @else
                                        <a href="{{ route('cliente.inscricoes.form', $evento) }}" class="btn btn-primary">Inscrever-se</a>
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
    const input = document.getElementById('search-input');
    const badge = document.getElementById('count-badge');
    const rows  = document.querySelectorAll('#eventos-table tbody tr');

    if (input) {
        input.addEventListener('input', () => {
            const term = input.value.toLowerCase().trim();
            let visible = 0;
            rows.forEach(row => {
                const match = !term || (row.dataset.search || '').includes(term);
                row.style.display = match ? '' : 'none';
                if (match) visible++;
            });
            badge.textContent = `${visible} ${visible === 1 ? 'evento' : 'eventos'}`;
        });
    }
</script>

@endsection