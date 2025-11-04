<?php
session_start(); // mantém a sessão ativa para exibir erros
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">       
    <title>Login - Loja de Eletrodomésticos SAEP</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0d6efd, #20c997);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .login-container {
            background: #fff;
            padding: 40px 50px;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.2);
            text-align: center;
            width: 350px;
        }

        h1 {
            color: #0d6efd;
            font-size: 1.6em;
            margin-bottom: 20px;
        }

        label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
            color: #333;
            font-weight: bold;
        }

        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 2px solid #ccc;
            border-radius: 8px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        input[type="email"]:focus, input[type="password"]:focus {
            border-color: #0d6efd;
            outline: none;
        }

        input[type="submit"] {
            width: 100%;
            background: #0d6efd;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 1em;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        input[type="submit"]:hover {
            background: #0b5ed7;
        }

        .erro {
            color: red;
            margin-bottom: 10px;
            font-weight: bold;
        }

        footer {
            position: absolute;
            bottom: 10px;
            color: white;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Login - Loja de Eletrodomésticos</h1>
        <form action="./../controller/controller_usuario.php" method="POST">
            <label>Email:</label>
            <input type="email" id="email" name="email" placeholder="Digite seu email..." required>

            <label>Senha:</label>
            <input type="password" id="senha" name="senha" placeholder="Digite sua senha..." required>

            <?php
                if(isset($_SESSION['erro_login'])){
                    echo '<div class="erro">'.$_SESSION['erro_login'].'</div>';
                    unset($_SESSION['erro_login']);
                }
            ?>

            <input type="submit" id="login" name="login" value="Acessar">
        </form>
    </div>
    <footer>© 2025 Loja de Eletrodomésticos SAEP</footer>
</body>
</html>
