<?php
require_once "../config/db.php";

class Usuario {
    public function buscar_usuario($email, $senha) {
        $conn = Database::getConnection();
        
        // Sanitiza dados básicos
        $email = trim($email);
        $senha = trim($senha);

        $select = $conn->prepare("SELECT * FROM USUARIO WHERE USU_EMAIL = ? AND USU_SENHA = ? LIMIT 1");
        $select->bind_param("ss", $email, $senha);
        $select->execute();
        $resultado = $select->get_result();

        return $resultado->fetch_assoc();
    }
}
?>
