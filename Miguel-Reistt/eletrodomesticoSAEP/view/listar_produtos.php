<?php
require_once "./../controller/controller_produto.php";

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$produto = new Produto();
if (isset($_POST['botao_pesquisar'])) {
    $resultados = $produto->filtrar_produto($_POST['pesquisar']);
} else {
    $resultados = $produto->listar_produtos();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">       
    <title>Lista de Produtos</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0d6efd, #20c997);
            color: #fff;
            min-height: 100vh;
            margin: 0;
            padding: 30px;
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            background: #fff;
            color: #333;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 25px rgba(0,0,0,0.2);
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ccc;
        }

        th {
            background: #0d6efd;
            color: #fff;
        }

        tr:hover {
            background: #f1f1f1;
        }

        input[type="search"] {
            padding: 10px;
            width: 250px;
            border-radius: 8px;
            border: none;
            margin-right: 10px;
        }

        input[type="submit"],
        button {
            background: #0d6efd;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 15px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }

        input[type="submit"]:hover,
        button:hover {
            background: #0b5ed7;
        }

        .botoes {
            margin-top: 20px;
        }

        a {
            text-decoration: none;
            color: inherit;
        }
    </style>
</head>
<body>
    <h1>Lista de Produtos</h1>

    <form method="POST">
        <input type="search" id="pesquisar" name="pesquisar" placeholder="Pesquisar...">
        <input type="submit" id="botao_pesquisar" name="botao_pesquisar" value="Filtrar">
    </form>
    
    <br>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Categoria</th>
            <th>Consumo Energético</th>
            <th>Garantia</th>
            <th>Prioridade de Reposição</th>
            <th>Editar</th>
            <th>Excluir</th>
        </tr>
        <?php
        if (count($resultados) > 0) {
            foreach ($resultados as $r) {
                echo "<tr>";  
                echo "<td>".$r['PROD_ID']."</td>";
                echo "<td>".$r['PROD_NOME']."</td>";
                echo "<td>".$r['PROD_DESCRICAO']."</td>";
                echo "<td>".$r['PROD_CATEGORIA']."</td>";
                echo "<td>".$r['PROD_CONSUMO_ENERGETICO']."</td>";
                echo "<td>".$r['PROD_GARANTIA']."</td>";
                echo "<td>".$r['PROD_PRIORIDADE_REPOSICAO']."</td>";
                echo "<td><a href='editar_produto.php?acao=editar_produto&id=".$r['PROD_ID']."'>Editar</a></td>";
                echo "<td><a href='./../controller/controller_produto.php?acao=excluir_produto&id=".$r['PROD_ID']."'>Excluir</a></td>";
                echo "</tr>";                            
            }
        } else {
            echo "<tr>";  
            echo "<th colspan='9'>Nenhum produto cadastrado!</th>";
            echo "</tr>";       
        }
        ?>
    </table>

    <div class="botoes">
        <a href="cadastro_produto.php"><button>Cadastrar Produto</button></a>
        <a href="inicial.php"><button>Voltar</button></a>
    </div>
</body>
</html>
