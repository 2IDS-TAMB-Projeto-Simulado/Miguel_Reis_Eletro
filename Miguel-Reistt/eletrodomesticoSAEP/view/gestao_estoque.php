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
    <title>Gestão de Estoque</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #198754, #0d6efd);
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

        input, select {
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        input[type="submit"], button {
            background: #0d6efd;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 15px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }

        input[type="submit"]:hover, button:hover {
            background: #0b5ed7;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .botoes {
            margin-top: 25px;
        }
    </style>
</head>
<body>
    <h1>Gestão de Estoque</h1>

    <form method="POST">
        <input type="search" id="pesquisar" name="pesquisar" placeholder="Pesquisar produto...">
        <input type="submit" id="botao_pesquisar" name="botao_pesquisar" value="Filtrar">
    </form>
    
    <br>

    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Categoria</th>
            <th>Quantidade em Estoque</th>
            <th>Ação</th>
            <th>Quantidade</th>
            <th>Atualizar Estoque</th>
        </tr>
        <?php
        if (count($resultados) > 0) {
            foreach ($resultados as $r) {
                echo "<form method='POST' action='./../controller/controller_estoque.php'>";
                echo "<tr>";  
                echo "<td><input type='number' name='produto_id' value='".$r["PROD_ID"]."' readonly></td>";
                echo "<td>".$r["PROD_NOME"]."</td>";
                echo "<td>".$r["PROD_DESCRICAO"]."</td>";
                echo "<td>".$r["PROD_CATEGORIA"]."</td>";
                echo "<td><input type='number' name='estoque_atual' value='".$r["ESTOQUE_QUANTIDADE"]."' readonly></td>";
                echo "<td>
                        <select name='acao_estoque' required>
                            <option value=''>Selecione...</option>
                            <option value='entrada'>Entrada no Estoque</option>
                            <option value='saida'>Saída do Estoque</option>
                        </select>
                      </td>";
                echo "<td><input type='number' name='qtd_aumentar_diminuir' min='0' required></td>";
                echo "<td><input type='submit' name='botao_atualizar' value='Atualizar Estoque'></td>";
                echo "</tr>";    
                echo "</form>";                        
            }
        } else {
            echo "<tr>";  
            echo "<th colspan='8'>Nenhum produto cadastrado!</th>";
            echo "</tr>";       
        }
        ?>
    </table>

    <div class="botoes">
        <a href="inicial.php"><button>Voltar</button></a>
    </div>
</body>
</html>
