<!DOCTYPE html>
<html lang="pt-br">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>@yield('titulo', 'Aroma do Grão - Cafeteria')</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f3e5d0;
    font-family: Arial, Helvetica, sans-serif;
}

/* NAVBAR */
.navbar{
    background:#a67850;
}

.navbar-brand{
    color:white;
    font-weight:bold;
}

.navbar a{
    color:white;
}

.navbar a:hover{
    color:#f3e5d0;
}

/* BOTÕES MENU */
.menu-btn{
    background:#6f4e37;
    color:white;
    border:none;
}

.menu-btn:hover{
    background:#5a3d2b;
    color:white;
}

/* CARDS */
.card{
    border-radius:15px;
    box-shadow:0 4px 10px rgba(111, 78, 55, 0.25);
    transition:0.3s;
}

.card:hover{
    transform:scale(1.02);
}

/* TITULOS */
h2, h4{
    color:#6f4e37;
    font-weight:bold;
}

</style>

</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
<div class="container">

<a class="navbar-brand d-flex align-items-center" href="/">
    <img src="{{ asset('imagens/logo.png') }}" alt="Logo" width="120" class="me-2">
</a>

<div>
    <a class="btn menu-btn me-2" href="{{ route('fornecedor.index') }}">Fornecedor</a>
    <a class="btn menu-btn me-2" href="{{ route('funcionario.index') }}">Funcionários</a>
    <a class="btn menu-btn me-2" href="{{ route('produto.index') }}">Produtos</a>
    <a class="btn menu-btn me-2" href="{{ route('pedido.index') }}">Pedidos</a>
    <a class="btn menu-btn me-2" href="{{ route('entrega.index') }}">Entrega</a>
    
</div>

</div>
</nav>

<!-- CONTEÚDO -->
<div class="container mt-4">

{{-- SUCESSO --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- ERRO --}}
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
<p style="color:#6f4e37">
    © {{ date('Y') }} Aroma do Grão - Cafeteria
</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- CONFIRMAÇÃO GLOBAL -->
<script>
function confirmarExclusao() {
    return confirm('Tem certeza que deseja excluir? Essa ação não pode ser desfeita.');
}
</script>

</body>
</html>