<?php
require_once "../config/db.php";

class Logs {
    public function cadastrar_logs($descricao) {
        $conn = Database::getConnection();
        
        $sql = "INSERT INTO LOGS (LOG_DESCRICAO, LOG_DATA_HORA) VALUES (?, NOW())";
        $insert = $conn->prepare($sql);
        
        if (!$insert) {
            die("Erro ao preparar o statement: " . $conn->error);
        }

        $insert->bind_param("s", $descricao);
        $success = $insert->execute();

        if (!$success) {
            error_log("Erro ao inserir log: " . $insert->error);
        }

        $insert->close();
        return $success;
    }
}
?>
