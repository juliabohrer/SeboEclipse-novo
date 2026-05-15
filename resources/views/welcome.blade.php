<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Aroma do Grão</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background: #f3e5d0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, Helvetica, sans-serif;
        }

        .container-box{
            text-align: center;
        }

        .logo{
            width: 250px;
            margin-bottom: 30px;
        }

        .btn-custom{
            background: #6f4e37;
            color: white;
            border: none;
            width: 200px;
            margin: 10px;
        }

        .btn-custom:hover{
            background: #5a3d2b;
            color: white;
        }
    </style>
</head>

<body>

<div class="container-box">

    <img src="{{ asset('imagens/logo.png') }}" class="logo" alt="Logo">

    <h2 class="mb-4">Aroma do Grão - Sistema</h2>

    <div>

        <a href="/fornecedor" class="btn btn-custom">Fornecedores</a>
        <a href="/funcionario" class="btn btn-custom">Funcionários</a>
        <a href="/produto" class="btn btn-custom">Produtos</a>
        <a href="/pedido" class="btn btn-custom">Pedidos</a>
        <a href="/entrega" class="btn btn-custom">Entrega</a>




    </div>

</div>

</body>
</html>