<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">

<style>

body{
    font-family: DejaVu Sans;
    background:#0d0d14;
    color:#e8e6f5;
    font-size:13px;
    margin:25px;
}

.header{
    text-align:center;
    border-bottom:2px solid #e2b85a;
    padding-bottom:15px;
    margin-bottom:25px;
}

.logo{
    font-size:32px;
    color:#a78bfa;
    font-weight:bold;
}

.logo span{
    color:#e2b85a;
}

.sub{
    color:#b0adc8;
    font-size:12px;
}

h2{
    color:#e2b85a;
    border-bottom:1px solid #444;
    padding-bottom:5px;
    margin-top:25px;
}

.cards{
    width:100%;
    margin-top:15px;
}

.card{
    width:47%;
    display:inline-block;
    vertical-align:top;
    background:#1a1830;
    border:1px solid #333;
    padding:15px;
    margin:5px;
    border-radius:8px;
}

.card h3{
    margin:0;
    font-size:13px;
    color:#b0adc8;
}

.valor{
    margin-top:8px;
    font-size:24px;
    color:#e2b85a;
    font-weight:bold;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:15px;
}

th{
    background:#221f3a;
    color:#e2b85a;
    padding:10px;
    text-align:left;
}

td{
    padding:10px;
    border-bottom:1px solid #333;
}

.footer{
    margin-top:40px;
    text-align:center;
    font-size:11px;
    color:#888;
}

.destaque{
    color:#6ee7b7;
    font-weight:bold;
}

.negativo{
    color:#f87171;
    font-weight:bold;
}

</style>

</head>

<body>

<div class="header">

<div class="logo">
Eclipse<span>.</span>Sebo
</div>

<div class="sub">
Relatório Administrativo Geral
</div>

<div class="sub">
Gerado em {{ date('d/m/Y H:i') }}
</div>

</div>

<h2>Resumo Financeiro</h2>

<div class="cards">

<div class="card">
<h3>Total em Compras</h3>

<div class="valor">
R$ {{ number_format($totalCompras,2,",",".") }}
</div>

</div>

<div class="card">
<h3>Total em Vendas</h3>

<div class="valor">
R$ {{ number_format($totalVendas,2,",",".") }}
</div>

</div>

<div class="card">
<h3>Total em Trocas</h3>

<div class="valor">
R$ {{ number_format($totalTrocas,2,",",".") }}
</div>

</div>

<div class="card">
<h3>Resultado Geral</h3>

<div class="valor">

@if($lucroBruto >= 0)

<span class="destaque">
R$ {{ number_format($lucroBruto,2,",",".") }}
</span>

@else

<span class="negativo">
R$ {{ number_format($lucroBruto,2,",",".") }}
</span>

@endif

</div>

</div>

</div>

<h2>Movimentação do Acervo</h2>

<table>

<tr>
<th>Operação</th>
<th>Quantidade</th>
</tr>

<tr>
<td>Livros Comprados</td>
<td>{{ $comprados }}</td>
</tr>

<tr>
<td>Livros Vendidos</td>
<td>{{ $vendidos }}</td>
</tr>

<tr>
<td>Livros Trocados</td>
<td>{{ $trocados }}</td>
</tr>

</table>

<h2>Situação do Estoque</h2>

<table>

<tr>
<th>Status</th>
<th>Quantidade</th>
</tr>

<tr>
<td>Total de Livros</td>
<td>{{ $totalLivros }}</td>
</tr>

<tr>
<td>Disponíveis</td>
<td>{{ $disponiveis }}</td>
</tr>

<tr>
<td>Indisponíveis</td>
<td>{{ $indisponiveis }}</td>
</tr>

</table>

<h2>Análise</h2>

<table>

<tr>
<td>

O Eclipse Sebo possui atualmente
<b>{{ $totalLivros }}</b> livros cadastrados.

Foram adquiridos
<b>{{ $comprados }}</b> livros,
vendidos
<b>{{ $vendidos }}</b>
e realizadas
<b>{{ $trocados }}</b>
trocas.

O resultado financeiro acumulado do sistema é de

@if($lucroBruto >= 0)

<span class="destaque">
R$ {{ number_format($lucroBruto,2,",",".") }}
</span>

@else

<span class="negativo">
R$ {{ number_format($lucroBruto,2,",",".") }}
</span>

@endif

.

</td>
</tr>

</table>

<div class="footer">

━━━━━━━━━━━━━━━━━━━━━━━━━━━

<br><br>

Eclipse Sebo • Sistema Administrativo

<br>

Relatório oficial do acervo e movimentações.

<br><br>

© {{ date('Y') }}

</div>

</body>
</html>