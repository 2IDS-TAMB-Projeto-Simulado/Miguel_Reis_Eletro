<?php
require_once "../config/db.php";
require_once "model_logs.php";

class Estoque {
    public function adicionar_estoque($quantidade, $fornecedor, $fk_prod_id) {
        $conn = Database::getConnection();
        $insert = $conn->prepare("INSERT INTO ESTOQUE (EST_QUANTIDADE, EST_FORNECEDOR, FK_PROD_ID) VALUES (?, ?, ?)");
        $insert->bind_param("isi", $quantidade, $fornecedor, $fk_prod_id);
        $success = $insert->execute();
        $insert->close();
        return $success;
    }

    public function atualizar_estoque($quantidade, $fk_prod_id, $fk_usu_id) {
        $conn = Database::getConnection();
        $update = $conn->prepare("UPDATE ESTOQUE SET EST_QUANTIDADE = ? WHERE FK_PROD_ID = ?");
        $update->bind_param("ii", $quantidade, $fk_prod_id);
        $success = $update->execute();

        if ($success) {
            $logs = new Logs();
            $logs->cadastrar_logs("PRODUTO <br>ID: $fk_prod_id <br>ESTOQUE atualizado para $quantidade unidades.<br>ID USUÁRIO: $fk_usu_id");
        }

        $update->close();
        return $success;
    }
}
?>
