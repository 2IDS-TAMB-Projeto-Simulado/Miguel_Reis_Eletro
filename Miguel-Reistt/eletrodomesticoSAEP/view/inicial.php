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
    <title>Página Inicial - Loja de Eletrodomésticos</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0d6efd, #20c997);
            color: #fff;
            text-align: center;
            padding-top: 80px;
            margin: 0;
        }

        h1 {
            font-size: 2.2em;
            margin-bottom: 10px;
        }

        h2 {
            font-size: 1.4em;
            font-weight: 500;
            margin-bottom: 20px;
        }

        h3 {
            font-weight: 400;
            margin-bottom: 40px;
        }

        button {
            background: #fff;
            color: #0d6efd;
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            margin: 10px;
            font-size: 1em;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }

        button:hover {
            background: #0b5ed7;
            color: #fff;
            transform: scale(1.05);
        }

        footer {
            position: absolute;
            bottom: 10px;
            width: 100%;
            text-align: center;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <h1>Página Inicial</h1>
    <h2>Loja de Eletrodomésticos SAEP</h2>
    <h3>Bem-vindo, <?php echo $_SESSION['usuario']['USU_NOME']; ?>!</h3>

    <a href="listar_produtos.php"><button>Gerenciar Produtos</button></a>
    <a href="gestao_estoque.php"><button>Gestão de Estoque</button></a>
    <a href="login.php"><button>Logout</button></a>

    <footer>© 2025 Loja de Eletrodomésticos SAEP</footer>
</body>
</html>
