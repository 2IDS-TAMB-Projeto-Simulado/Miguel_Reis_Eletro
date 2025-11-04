<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">       
    <title>Cadastro de Produtos</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0d6efd, #20c997);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin: 0;
            color: #fff;
        }

        h1 {
            margin-bottom: 20px;
        }

        form {
            background: #fff;
            color: #333;
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.2);
            width: 400px;
            text-align: left;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 2px solid #ccc;
            border-radius: 8px;
            margin-bottom: 15px;
            transition: 0.3s;
        }

        input[type="text"]:focus,
        input[type="number"]:focus {
            border-color: #0d6efd;
            outline: none;
        }

        input[type="submit"],
        button {
            background: #0d6efd;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }

        input[type="submit"]:hover,
        button:hover {
            background: #0b5ed7;
        }

        .voltar {
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <h1>Cadastro de Produtos</h1>
    <form action="./../controller/controller_produto.php" method="POST">
        <label>Nome do Produto:</label>
        <input type="text" id="nome" name="nome" placeholder="Ex: Geladeira Frost Free..." required>

        <label>Descrição:</label>
        <input type="text" id="descricao" name="descricao" placeholder="Detalhes do produto..." required>

        <label>Categoria:</label>
        <input type="text" id="categoria" name="categoria" placeholder="Ex: Eletrodoméstico Grande..." required>

        <label>Consumo Energético:</label>
        <input type="text" id="consumo" name="consumo" placeholder="Ex: A++, A+, etc." required>

        <label>Garantia:</label>
        <input type="text" id="garantia" name="garantia" placeholder="Ex: 12 meses..." required>

        <label>Prioridade de Reposição:</label>
        <input type="text" id="prioridade" name="prioridade" placeholder="Ex: Alta, Média, Baixa..." required>

        <input type="submit" id="cadastrar_produto" name="cadastrar_produto" value="Cadastrar">
    </form>

    <div class="voltar">
        <a href="inicial.php"><button>Voltar</button></a>
    </div>
</body>
</html>
