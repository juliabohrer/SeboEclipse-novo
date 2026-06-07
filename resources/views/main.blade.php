<!DOCTYPE html>
<html lang="pt-br">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>@yield('titulo', 'Eclipse Sebo - Livraria')</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Crimson+Pro:ital,wght@0,300;0,400;1,300&display=swap" rel="stylesheet">

<style>

:root {
    --void:      #0d0d14;
    --deep:      #12111f;
    --surface:   #1a1830;
    --overlay:   #221f3a;
    --border:    rgba(180,160,255,.15);
    --border-md: rgba(180,160,255,.28);
    --purple:    #a78bfa;
    --purple-lt: #c4b5fd;
    --gold:      #e2b85a;
    --muted:     #7c7a9e;
    --text:      #e8e6f5;
    --text-dim:  #b0adc8;
    --green:     #6ee7b7;
    --green-bg:  rgba(110,231,183,.08);
    --rust:      #f87171;
    --rust-bg:   rgba(248,113,113,.08);
}

body {
    background: var(--void);
    font-family: 'Crimson Pro', Georgia, serif;
    color: var(--text);
}

/* NAVBAR */
.navbar {
    background: rgba(13,13,20,.95);
    border-bottom: 1px solid var(--border);
    backdrop-filter: blur(12px);
}

.navbar-brand {
    font-family: 'Cinzel', serif;
    font-weight: 700;
    font-size: 1.2rem;
    color: var(--text) !important;
    letter-spacing: .06em;
}

.navbar-brand span { color: var(--gold); }

.navbar a {
    color: var(--text-dim) !important;
    font-family: 'Cinzel', serif;
    font-size: .75rem;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.navbar a:hover { color: var(--purple-lt) !important; }

/* BOTÕES MENU */
.menu-btn {
    background: rgba(167,139,250,.1);
    color: var(--purple-lt) !important;
    border: 1px solid rgba(167,139,250,.35);
    font-family: 'Cinzel', serif;
    font-size: .68rem;
    letter-spacing: .1em;
    text-transform: uppercase;
    transition: all .2s;
}

.menu-btn:hover {
    background: rgba(167,139,250,.22);
    border-color: var(--purple);
    color: var(--purple-lt) !important;
    box-shadow: 0 0 16px rgba(124,58,237,.2);
}

/* SAUDAÇÃO DO USUÁRIO */
.user-greeting {
    font-family: 'Cinzel', serif;
    font-size: .68rem;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: var(--gold);
    padding: .4rem .6rem;
    border-left: 1px solid var(--border);
    margin-left: .25rem;
}

/* BOTÃO LOGOUT */
.btn-logout {
    background: transparent;
    border: 1px solid rgba(248,113,113,.3);
    color: var(--rust);
    font-family: 'Cinzel', serif;
    font-size: .65rem;
    letter-spacing: .1em;
    text-transform: uppercase;
    padding: .45rem .9rem;
    border-radius: 6px;
    cursor: pointer;
    transition: all .2s;
}

.btn-logout:hover {
    background: var(--rust-bg);
    border-color: var(--rust);
    color: var(--rust);
}

/* CARDS */
.card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0,0,0,.4);
    transition: .3s;
    color: var(--text);
    overflow: hidden;
}

.card-body { padding: 2rem 2.25rem; }

.card-footer {
    padding: 1.2rem 2.25rem;
    background: var(--overlay);
    border-top: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: .9rem;
}

/* TÍTULOS */
h1, h2, h4 {
    font-family: 'Cinzel', serif;
    font-weight: 700;
}

h2, h4 {
    background: linear-gradient(135deg, var(--purple-lt) 0%, var(--gold) 70%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* ALERTS */
.alert-success {
    background: var(--green-bg);
    border: 1px solid rgba(110,231,183,.25);
    color: var(--green);
}

.alert-danger {
    background: var(--rust-bg);
    border: 1px solid rgba(248,113,113,.25);
    color: var(--rust);
}

.alert-error {
    background: var(--rust-bg);
    border: 1px solid rgba(248,113,113,.25);
    color: var(--rust);
    padding: .85rem 1.2rem;
    border-radius: 6px;
    margin-bottom: 1.5rem;
    font-size: .9rem;
}

.alert-error ul { list-style: none; }
.alert-error ul li::before { content: '— '; }
.alert-error strong { display: block; margin-bottom: .4rem; }

/* BOTÕES */
.btn {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    padding: .6rem 1.3rem;
    font-family: 'Cinzel', serif;
    font-size: .72rem;
    font-weight: 600;
    letter-spacing: .1em;
    text-transform: uppercase;
    border-radius: 6px;
    border: 1px solid transparent;
    cursor: pointer;
    text-decoration: none;
    transition: all .2s;
    white-space: nowrap;
}

.btn-primary {
    background: rgba(167,139,250,.12);
    border-color: rgba(167,139,250,.4);
    color: var(--purple-lt);
}

.btn-primary:hover {
    background: rgba(167,139,250,.22);
    border-color: var(--purple);
    box-shadow: 0 0 20px rgba(124,58,237,.25);
    transform: translateY(-1px);
    color: var(--purple-lt);
}

.btn-ghost {
    background: transparent;
    border-color: var(--border-md);
    color: var(--text-dim);
    padding: .4rem .85rem;
    font-size: .65rem;
}

.btn-ghost:hover {
    border-color: var(--purple);
    color: var(--purple-lt);
}

.btn-danger {
    background: transparent;
    border-color: rgba(248,113,113,.3);
    color: var(--rust);
    padding: .4rem .85rem;
    font-size: .65rem;
}

.btn-danger:hover {
    background: var(--rust-bg);
    border-color: var(--rust);
    color: var(--rust);
}

/* TOP BAR */
.top-bar {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid var(--border);
    position: relative;
}

.top-bar::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 0;
    width: 60px;
    height: 1px;
    background: var(--gold);
}

.heading .tag {
    font-size: .68rem;
    font-weight: 400;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: var(--gold);
    font-family: 'Cinzel', serif;
    margin-bottom: .5rem;
}

.heading h1 {
    font-size: 1.9rem;
    letter-spacing: .05em;
    background: linear-gradient(135deg, var(--purple-lt) 0%, var(--gold) 70%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.heading .subtitle {
    font-style: italic;
    font-size: .9rem;
    color: var(--muted);
    margin-top: .3rem;
}

/* PAGE HEADER (forms) */
.page-header {
    margin-bottom: 2.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid var(--border);
    position: relative;
}

.page-header::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 0;
    width: 60px;
    height: 1px;
    background: var(--gold);
}

.page-header .tag {
    font-family: 'Cinzel', serif;
    font-size: .68rem;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: var(--gold);
    margin-bottom: .5rem;
}

.page-header h1 {
    font-size: 1.9rem;
    letter-spacing: .05em;
    background: linear-gradient(135deg, var(--purple-lt) 0%, var(--gold) 70%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* TOOLBAR */
.toolbar {
    display: flex;
    align-items: center;
    gap: .75rem;
    margin-bottom: 1.25rem;
    flex-wrap: wrap;
}

.search-wrap {
    position: relative;
    flex: 1;
    min-width: 180px;
    max-width: 340px;
}

.search-wrap svg {
    position: absolute;
    left: .75rem;
    top: 50%;
    transform: translateY(-50%);
    width: 14px;
    height: 14px;
    stroke: var(--muted);
    fill: none;
    stroke-width: 2;
    pointer-events: none;
}

.search-input {
    width: 100%;
    height: 48px;
    padding: 0 18px;
    font-family: 'Crimson Pro', serif;
    font-size: 1rem;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 10px;
    outline: none;
    color: var(--text);
    transition: all .2s;
}

.search-input::placeholder { color: var(--muted); }

.search-input:focus {
    border-color: var(--gold);
    box-shadow: 0 0 0 3px rgba(226,184,90,.15);
}

.search-bar {
    margin-bottom: 1.5rem;
}

.search-bar form {
    display: flex;
    gap: .75rem;
    align-items: center;
}

.count-badge {
    margin-left: auto;
    font-size: .8rem;
    font-style: italic;
    color: var(--muted);
}

/* TABLE */
.table-wrap {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 8px;
    overflow: hidden;
}

table { width: 100%; border-collapse: collapse; }

thead tr {
    background: var(--overlay);
    border-bottom: 1px solid var(--border-md);
}

thead th {
    padding: .85rem 1.1rem;
    text-align: left;
    font-family: 'Cinzel', serif;
    font-size: .62rem;
    font-weight: 600;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: var(--muted);
}

thead th:last-child { text-align: right; }

tbody tr {
    border-bottom: 1px solid rgba(180,160,255,.07);
    transition: background .15s;
}

tbody tr:last-child { border-bottom: none; }
tbody tr:hover { background: rgba(167,139,250,.05); }

tbody td {
    padding: .95rem 1.1rem;
    font-size: .95rem;
    vertical-align: middle;
}

tbody td:last-child { text-align: right; }

.td-title strong, .td-nome strong {
    font-weight: 400;
    color: var(--text);
    display: block;
    line-height: 1.3;
}

.td-title small, .td-nome small {
    font-size: .82rem;
    font-style: italic;
    color: var(--muted);
}

.td-price {
    font-family: 'Cinzel', serif;
    font-size: .85rem;
    color: var(--gold);
}

/* BADGES */
.badge {
    display: inline-block;
    padding: .2rem .65rem;
    border-radius: 99px;
    font-family: 'Cinzel', serif;
    font-size: .6rem;
    letter-spacing: .08em;
    font-weight: 600;
    text-transform: uppercase;
}

.badge-novo    { background: rgba(110,231,183,.1);  color: #6ee7b7; border: 1px solid rgba(110,231,183,.25); }
.badge-otimo   { background: rgba(167,139,250,.1);  color: #c4b5fd; border: 1px solid rgba(167,139,250,.25); }
.badge-bom     { background: rgba(226,184,90,.1);   color: #e2b85a; border: 1px solid rgba(226,184,90,.25); }
.badge-regular { background: rgba(251,146,60,.1);   color: #fb923c; border: 1px solid rgba(251,146,60,.25); }
.badge-ruim    { background: rgba(248,113,113,.1);  color: #f87171; border: 1px solid rgba(248,113,113,.25); }
.badge-admin   { background: rgba(226,184,90,.1);   color: #e2b85a; border: 1px solid rgba(226,184,90,.25); }
.badge-cliente { background: rgba(167,139,250,.1);  color: #c4b5fd; border: 1px solid rgba(167,139,250,.25); }

/* DOT (disponível) */
.dot {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    font-size: .82rem;
    font-style: italic;
    color: var(--muted);
}

.dot::before {
    content: '';
    width: 7px;
    height: 7px;
    border-radius: 50%;
    flex-shrink: 0;
}

.dot-yes { color: var(--green); }
.dot-yes::before { background: var(--green); box-shadow: 0 0 6px rgba(110,231,183,.5); }
.dot-no::before  { background: var(--muted); }

/* ACTIONS */
.actions { display: inline-flex; align-items: center; gap: .4rem; }

/* EMPTY STATE */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: var(--muted);
}

.empty-state p {
    font-family: 'Cinzel', serif;
    font-size: 1rem;
    margin-bottom: .5rem;
    color: var(--text-dim);
}

.empty-state span { font-size: .85rem; font-style: italic; }

/* FORM */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.4rem 1.75rem;
}

.form-group { display: flex; flex-direction: column; gap: .4rem; }
.form-group.full { grid-column: 1 / -1; }

label {
    font-family: 'Cinzel', serif;
    font-size: .62rem;
    font-weight: 600;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: var(--muted);
}

input[type="text"],
input[type="number"],
input[type="email"],
input[type="password"],
input[type="date"],
input[type="datetime-local"],
input[type="file"],
textarea,
select {
    width: 100%;
    padding: .65rem .9rem;
    font-family: 'Crimson Pro', serif;
    font-size: 1rem;
    color: var(--text);
    background: var(--deep);
    border: 1px solid var(--border);
    border-radius: 6px;
    outline: none;
    transition: border-color .2s, box-shadow .2s;
    appearance: none;
}

textarea {
    resize: vertical;
    min-height: 100px;
}

input:focus,
select:focus,
textarea:focus {
    border-color: rgba(167,139,250,.5);
    box-shadow: 0 0 0 3px rgba(124,58,237,.1);
}

input.is-invalid,
select.is-invalid,
textarea.is-invalid {
    border-color: rgba(248,113,113,.5);
    box-shadow: 0 0 0 3px rgba(248,113,113,.08);
}

input::placeholder,
textarea::placeholder { color: var(--muted); }

select option { background: var(--deep); color: var(--text); }

/* Cor do calendário/clock no datetime-local */
input[type="datetime-local"]::-webkit-calendar-picker-indicator,
input[type="date"]::-webkit-calendar-picker-indicator {
    filter: invert(0.6) sepia(1) saturate(2) hue-rotate(220deg);
    cursor: pointer;
}

.field-error {
    font-size: .8rem;
    font-style: italic;
    color: var(--rust);
}

.field-hint {
    font-size: .78rem;
    font-style: italic;
    color: var(--muted);
}

.section-divider {
    grid-column: 1 / -1;
    display: flex;
    align-items: center;
    gap: .75rem;
    margin: .3rem 0;
}

.section-divider span {
    font-family: 'Cinzel', serif;
    font-size: .6rem;
    font-weight: 600;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: var(--gold);
    white-space: nowrap;
}

.section-divider::before, .section-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: var(--border);
}

.checkbox-row {
    display: flex;
    align-items: center;
    gap: .65rem;
    padding: .8rem 1rem;
    background: var(--deep);
    border: 1px solid var(--border);
    border-radius: 6px;
    cursor: pointer;
    user-select: none;
    transition: border-color .2s;
}

.checkbox-row:hover { border-color: rgba(167,139,250,.35); }

.checkbox-row input[type="checkbox"] {
    width: 16px;
    height: 16px;
    accent-color: var(--purple);
    cursor: pointer;
    flex-shrink: 0;
}

.checkbox-row .cb-label {
    font-size: .95rem;
    color: var(--text-dim);
    letter-spacing: normal;
    text-transform: none;
    font-family: 'Crimson Pro', serif;
}

.checkbox-row .cb-hint {
    margin-left: auto;
    font-size: .78rem;
    font-style: italic;
    color: var(--muted);
}

/* FOOTER */
footer p {
    color: var(--muted);
    font-style: italic;
    font-size: .85rem;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .col-editora, .col-genero, .col-cpf, .col-endereco { display: none; }
}

@media (max-width: 600px) {
    .form-grid { grid-template-columns: 1fr; }
    .form-group.full { grid-column: 1; }
    .card-body { padding: 1.5rem 1.25rem; }
    .card-footer { flex-direction: column-reverse; }
    .btn { width: 100%; justify-content: center; }
    .checkbox-row .cb-hint { display: none; }
}

@media (max-width: 480px) {
    .col-telefone, .col-estado { display: none; }
    .top-bar { flex-direction: column; align-items: flex-start; }
}

</style>

</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
<div class="container d-flex align-items-center justify-content-between">

    <a class="navbar-brand" href="/">Eclipse<span>.</span>Sebo</a>

    <div class="d-flex align-items-center gap-2 flex-wrap">

        @guest
            <a class="btn menu-btn" href="{{ route('login') }}">Entrar</a>
        @endguest

        @auth
            @if(auth()->user()->tipo === 'adm')
                <a class="btn menu-btn me-1" href="{{ route('usuarios.index') }}">Usuários</a>
                <a class="btn menu-btn me-1" href="{{ route('eventos.index') }}">Eventos</a>
                <a class="btn menu-btn me-1" href="{{ route('livros.index') }}">Livros</a>
                <a class="btn menu-btn me-1" href="{{ route('troca-livros.index') }}">Trocas</a>
                <a class="btn menu-btn me-1" href="{{ route('compras.index') }}">Compras</a>
                <a class="btn menu-btn me-1" href="{{ route('vendas.index') }}">Vendas</a>
            @else
                <a class="btn menu-btn me-1" href="{{ route('cliente.livros') }}">Livros</a>
                <a class="btn menu-btn me-1" href="{{ route('cliente.eventos') }}">Eventos</a>
                <a class="btn menu-btn me-1" href="{{ route('cliente.trocas') }}">Trocas</a>
                <a class="btn menu-btn me-1" href="{{ route('cliente.perfil') }}">Meu Perfil</a>
            @endif

            <span class="user-greeting">{{ auth()->user()->nome }}</span>

            <form method="POST" action="{{ route('logout') }}" style="margin:0">
                @csrf
                <button type="submit" class="btn-logout">Sair</button>
            </form>
        @endauth

    </div>
</div>
</nav>

<!-- CONTEÚDO -->
<div class="container mt-4">

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@yield('content')

</div>

<!-- FOOTER -->
<footer class="text-center mt-5 mb-3">
<p>© {{ date('Y') }} Eclipse Sebo - Livraria</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
function confirmarExclusao() {
    return confirm('Tem certeza que deseja excluir? Essa ação não pode ser desfeita.');
}


</script>

</body>
</html>