<?php
require_once "../model/model_produto.php";
session_start();

// CADASTRAR PRODUTO
if (isset($_POST["cadastrar_produto"])) {
    $produto = new Produto();

    // campos que existem no seu form cadastro_produto.php
    $nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
    $descricao = isset($_POST['descricao']) ? trim($_POST['descricao']) : '';
    $categoria = isset($_POST['categoria']) ? trim($_POST['categoria']) : '';
    $consumo = isset($_POST['consumo']) ? trim($_POST['consumo']) : '';
    $garantia = isset($_POST['garantia']) ? trim($_POST['garantia']) : '';
    $prioridade = isset($_POST['prioridade']) ? trim($_POST['prioridade']) : '';

    $fk_usuario = $_SESSION['usuario']["USU_ID"];

    // chamar o model (ele criará o registro de estoque com valores padrão)
    $resultado = $produto->cadastrar_produto(
        $nome,
        $descricao,
        $categoria,
        $fk_usuario,
        $consumo,
        $garantia,
        $prioridade
    );

    if ($resultado) {
        echo "<script>
                alert('Produto cadastrado com sucesso!');
                window.location.href='../view/listar_produtos.php';
            </script>";
    } else {
        echo "<script>
                alert('Erro ao cadastrar produto!');
                window.location.href='../view/listar_produtos.php';
            </script>";
    }
    exit();
}

// BUSCAR DADOS PARA EDITAR PRODUTO
else if (isset($_GET["acao"]) && $_GET["acao"] == "editar_produto") {
    $produto = new Produto();
    $resultados = $produto->buscar_produto_pelo_id($_GET["id"]);

    if (!empty($resultados)) {
        $produto_editar = $resultados;
        // $produto_editar já é assoc (ver seu model). Na view use $produto_editar['PROD_NOME'] etc.
    } else {
        echo "<script>
                alert('Produto não encontrado!');
                window.location.href='../view/listar_produtos.php';
            </script>";
        exit();
    }
}

// EDITAR PRODUTO
if (isset($_POST["editar_produto"])) {
    $produto = new Produto();

    $nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
    $descricao = isset($_POST['descricao']) ? trim($_POST['descricao']) : '';
    $categoria = isset($_POST['categoria']) ? trim($_POST['categoria']) : '';
    $consumo = isset($_POST['consumo']) ? trim($_POST['consumo']) : '';
    $garantia = isset($_POST['garantia']) ? trim($_POST['garantia']) : '';
    $prioridade = isset($_POST['prioridade']) ? trim($_POST['prioridade']) : '';

    $produto_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $fk_usuario = $_SESSION['usuario']["USU_ID"];

    $resultado = $produto->editar_produto(
        $nome,
        $descricao,
        $categoria,
        $consumo,
        $garantia,
        $prioridade,
        $produto_id,
        $fk_usuario
    );

    if ($resultado) {
        echo "<script>
                alert('Produto atualizado com sucesso!');
                window.location.href='../view/listar_produtos.php';
            </script>";
    } else {
        echo "<script>
                alert('Erro ao atualizar produto!');
                window.location.href='../view/listar_produtos.php';
            </script>";
    }
    exit();
}

// EXCLUIR PRODUTO
else if (isset($_GET["acao"]) && $_GET["acao"] == "excluir_produto") {
    $produto = new Produto();
    $resultado = $produto->excluir_produto($_GET["id"], $_SESSION['usuario']['USU_ID']);
    if ($resultado) {
        echo "<script>
                alert('Produto excluído com sucesso!');
                window.location.href='../view/listar_produtos.php';
            </script>";
    } else {
        echo "<script>
                alert('Erro ao excluir produto!');
                window.location.href='../view/listar_produtos.php';
            </script>";
    }
    exit();
}
?>
