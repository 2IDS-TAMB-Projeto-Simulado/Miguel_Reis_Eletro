<?php
require_once "../model/model_estoque.php";
session_start();

if (isset($_POST['botao_atualizar'])) {

    $estoqueAtual = intval($_POST['estoque_atual']);
    $qtdAlterar = intval($_POST['qtd_aumentar_diminuir']);
    $acao = $_POST['acao_estoque']; // "entrada" ou "saida"
    $produto_id = intval($_POST['produto_id']);
    $usuario_id = $_SESSION['usuario']['USU_ID'];

    // Calcula nova quantidade
    if ($acao === "entrada") {
        $nova_qtd = $estoqueAtual + $qtdAlterar;
    } elseif ($acao === "saida") {
        $nova_qtd = $estoqueAtual - $qtdAlterar;
        if ($nova_qtd < 0) $nova_qtd = 0;
    } else {
        echo "<script>alert('Ação inválida!'); history.back();</script>";
        exit();
    }

    // Atualiza o estoque
    $estoque = new Estoque();
    $success = $estoque->atualizar_estoque($nova_qtd, $produto_id, $usuario_id);

    // Mensagens de retorno
    if ($success) {
        if ($nova_qtd <= 50) {
            echo "<script>
                    alert('⚠️ Atenção: Estoque do produto está baixo ($nova_qtd unidades)!');
                    window.location.href = './../view/gestao_estoque.php';
                  </script>";
        } else {
            echo "<script>
                    alert('✅ Estoque atualizado com sucesso! Quantidade atual: $nova_qtd');
                    window.location.href = './../view/gestao_estoque.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('❌ Erro ao atualizar o estoque!');
                window.location.href = './../view/gestao_estoque.php';
              </script>";
    }
}
?>
