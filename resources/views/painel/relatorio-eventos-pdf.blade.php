<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #1a1a2e;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #a78bfa;
            padding-bottom: 12px;
            margin-bottom: 24px;
        }

        .header h1 {
            font-size: 20px;
            color: #7c3aed;
            margin: 0 0 4px;
        }

        .header p {
            font-size: 11px;
            color: #6b7280;
            margin: 0;
        }

        .cards {
            display: table;
            width: 100%;
            margin-bottom: 24px;
        }

        .card {
            display: table-cell;
            width: 33%;
            background: #f5f3ff;
            border: 1px solid #ddd6fe;
            border-radius: 6px;
            padding: 10px 14px;
            text-align: center;
        }

        .card + .card { margin-left: 10px; }

        .card .label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #7c3aed;
            margin-bottom: 4px;
        }

        .card .valor {
            font-size: 20px;
            font-weight: bold;
            color: #4c1d95;
        }

        h2 {
            font-size: 13px;
            color: #4c1d95;
            border-bottom: 1px solid #ddd6fe;
            padding-bottom: 6px;
            margin: 20px 0 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        thead tr {
            background: #7c3aed;
            color: #fff;
        }

        thead th {
            padding: 7px 10px;
            text-align: left;
        }

        tbody tr:nth-child(even) { background: #f5f3ff; }

        tbody td {
            padding: 6px 10px;
            border-bottom: 1px solid #ede9fe;
        }

        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 99px;
            font-size: 9px;
            font-weight: bold;
        }

        .badge-lotado   { background: #fee2e2; color: #b91c1c; }
        .badge-aberto   { background: #d1fae5; color: #065f46; }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }

        .popular-box {
            background: #f5f3ff;
            border: 1px solid #ddd6fe;
            border-radius: 6px;
            padding: 10px 14px;
            margin-bottom: 20px;
        }

        .popular-box .titulo {
            font-size: 14px;
            font-weight: bold;
            color: #4c1d95;
        }

        .popular-box .sub {
            font-size: 10px;
            color: #6b7280;
            margin-top: 2px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Relatório de Eventos</h1>
        <p>{{ now()->locale('pt_BR')->isoFormat('MMMM [de] YYYY') }} · Eclipse Sebo</p>
    </div>

    {{-- Cards resumo --}}
    <div class="cards">
        <div class="card">
            <div class="label">Eventos no Mês</div>
            <div class="valor">{{ $eventosMes->count() }}</div>
        </div>
        <div class="card">
            <div class="label">Inscrições no Mês</div>
            <div class="valor">{{ $totalInscricoesMes }}</div>
        </div>
        <div class="card">
            <div class="label">Receita Estimada</div>
            <div class="valor">R$ {{ number_format($receitaMes, 2, ',', '.') }}</div>
        </div>
    </div>

    {{-- Evento mais popular --}}
    @if($eventoMaisPopular)
        <h2>Evento Mais Popular</h2>
        <div class="popular-box">
            <div class="titulo">{{ $eventoMaisPopular->titulo }}</div>
            <div class="sub">
                {{ $eventoMaisPopular->inscricoes->count() }} inscritos
                · Início: {{ $eventoMaisPopular->data_hora_inicio->format('d/m/Y H:i') }}
                · Limite: {{ $eventoMaisPopular->limite_pessoas }} pessoas
            </div>
        </div>
    @endif

    {{-- Tabela de eventos --}}
    <h2>Eventos do Mês</h2>

    @if($eventosMes->isEmpty())
        <p style="color:#6b7280; font-style:italic;">Nenhum evento neste mês.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Evento</th>
                    <th>Início</th>
                    <th>Inscritos</th>
                    <th>Limite</th>
                    <th>Valor</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($eventosMes as $evento)
                    @php
                        $inscritos = $evento->inscricoes->count();
                        $lotado    = $inscritos >= $evento->limite_pessoas;
                    @endphp
                    <tr>
                        <td>{{ $evento->titulo }}</td>
                        <td>{{ $evento->data_hora_inicio->format('d/m/Y H:i') }}</td>
                        <td>{{ $inscritos }}</td>
                        <td>{{ $evento->limite_pessoas }}</td>
                        <td>R$ {{ number_format($evento->valor_ingresso, 2, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $lotado ? 'badge-lotado' : 'badge-aberto' }}">
                                {{ $lotado ? 'Lotado' : 'Aberto' }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="footer">
        Gerado em {{ now()->format('d/m/Y H:i') }} · Eclipse Sebo
    </div>

</body>
</html>