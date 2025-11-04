<?php
require_once "../config/db.php";
require_once "model_estoque.php";
require_once "model_logs.php";

class Produto {
    
    // Cadastrar novo produto
    public function cadastrar_produto($nome, $descricao, $categoria, $fk_usu_id, $consumo_energetico, $garantia, $prioridade_reposicao) {
        $conn = Database::getConnection();

        $insert = $conn->prepare("INSERT INTO PRODUTO 
            (PROD_NOME, PROD_DESCRICAO, PROD_CATEGORIA, FK_USU_ID, PROD_CONSUMO_ENERGETICO, PROD_GARANTIA, PROD_PRIORIDADE_REPOSICAO)
            VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insert->bind_param("sssisss", $nome, $descricao, $categoria, $fk_usu_id, $consumo_energetico, $garantia, $prioridade_reposicao);
        $success = $insert->execute();

        if ($success) {
            $produto_id = $conn->insert_id;

            // Cria registro de estoque com quantidade inicial 0
            $estoque = new Estoque();
            $estoque->adicionar_estoque(0, 'Fornecedor Padrão', $produto_id);

            // Registra log
            $logs = new Logs();
            $logs->cadastrar_logs("PRODUTO <br> ID: ".$produto_id." <br> NOME: ".$nome." <br> AÇÃO: Cadastrado! <br> ID USUÁRIO: ".$fk_usu_id);
        }

        $insert->close();
        return $success;
    }

    // Listar todos os produtos
    public function listar_produtos() {
        $conn = Database::getConnection();
        $sql = "SELECT 
                    P.PROD_ID,
                    P.PROD_NOME,
                    P.PROD_DESCRICAO,
                    P.PROD_CATEGORIA,
                    P.PROD_CONSUMO_ENERGETICO,
                    P.PROD_GARANTIA,
                    P.PROD_PRIORIDADE_REPOSICAO,
                    E.EST_QUANTIDADE AS ESTOQUE_QUANTIDADE,
                    U.USU_NOME,
                    U.USU_EMAIL
                FROM PRODUTO P
                JOIN USUARIO U ON P.FK_USU_ID = U.USU_ID
                JOIN ESTOQUE E ON P.PROD_ID = E.FK_PROD_ID
                ORDER BY P.PROD_NOME";
        $result = $conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Excluir produto
    public function excluir_produto($id, $fk_usu_id) {
        $conn = Database::getConnection();
        $logs = new Logs();

        // 1️⃣ Apaga o estoque vinculado ao produto
        $deleteEstoque = $conn->prepare("DELETE FROM ESTOQUE WHERE FK_PROD_ID = ?");
        $deleteEstoque->bind_param("i", $id);
        $deleteEstoque->execute();
        $deleteEstoque->close();

        // 2️⃣ Agora pode apagar o produto
        $deleteProduto = $conn->prepare("DELETE FROM PRODUTO WHERE PROD_ID = ?");
        $deleteProduto->bind_param("i", $id);
        $success = $deleteProduto->execute();
        $deleteProduto->close();

        if ($success) {
            $logs->cadastrar_logs("PRODUTO <br> ID: $id <br> AÇÃO: Excluído <br> ID USUÁRIO: $fk_usu_id");
        }

        return $success;
    }

    // Buscar produto por ID
    public function buscar_produto_pelo_id($id) {
        $conn = Database::getConnection();
        $select = $conn->prepare("SELECT 
                                    P.PROD_ID,
                                    P.PROD_NOME,
                                    P.PROD_DESCRICAO,
                                    P.PROD_CATEGORIA,
                                    P.PROD_CONSUMO_ENERGETICO,
                                    P.PROD_GARANTIA,
                                    P.PROD_PRIORIDADE_REPOSICAO,
                                    E.EST_QUANTIDADE AS ESTOQUE_QUANTIDADE,
                                    U.USU_NOME,
                                    U.USU_EMAIL
                                FROM PRODUTO P
                                JOIN USUARIO U ON P.FK_USU_ID = U.USU_ID
                                JOIN ESTOQUE E ON P.PROD_ID = E.FK_PROD_ID
                                WHERE P.PROD_ID = ?
                                ORDER BY P.PROD_NOME");
        $select->bind_param("i", $id);
        $select->execute();
        $result = $select->get_result();
        $produto = $result->fetch_assoc();
        $select->close();
        return $produto;
    }

    // Editar produto
    public function editar_produto($nome, $descricao, $categoria, $consumo_energetico, $garantia, $prioridade_reposicao, $produto_id, $fk_usu_id) {
        $conn = Database::getConnection();
        $update = $conn->prepare("UPDATE PRODUTO 
                                  SET PROD_NOME = ?, PROD_DESCRICAO = ?, PROD_CATEGORIA = ?, 
                                      PROD_CONSUMO_ENERGETICO = ?, PROD_GARANTIA = ?, PROD_PRIORIDADE_REPOSICAO = ?
                                  WHERE PROD_ID = ?");
        $update->bind_param("ssssssi", $nome, $descricao, $categoria, $consumo_energetico, $garantia, $prioridade_reposicao, $produto_id);
        $success = $update->execute();

        if ($success) {
            $logs = new Logs();
            $logs->cadastrar_logs("PRODUTO <br> ID: ".$produto_id." <br> NOME: ".$nome." <br> AÇÃO: Editado! <br> ID USUÁRIO: ".$fk_usu_id);
        }

        $update->close();
        return $success;
    }

    // Filtrar produto por nome
    public function filtrar_produto($campo) {
        $conn = Database::getConnection();
        $select = $conn->prepare("SELECT 
                                    P.PROD_ID,
                                    P.PROD_NOME,
                                    P.PROD_DESCRICAO,
                                    P.PROD_CATEGORIA,
                                    P.PROD_CONSUMO_ENERGETICO,
                                    P.PROD_GARANTIA,
                                    P.PROD_PRIORIDADE_REPOSICAO,
                                    E.EST_QUANTIDADE AS ESTOQUE_QUANTIDADE,
                                    U.USU_NOME,
                                    U.USU_EMAIL
                                FROM PRODUTO P
                                JOIN USUARIO U ON P.FK_USU_ID = U.USU_ID
                                JOIN ESTOQUE E ON P.PROD_ID = E.FK_PROD_ID
                                WHERE P.PROD_NOME LIKE ?
                                ORDER BY P.PROD_NOME");
        $termo = "%" . $campo . "%";
        $select->bind_param("s", $termo);
        $select->execute();
        $result = $select->get_result();
        $produtos = $result->fetch_all(MYSQLI_ASSOC);
        $select->close();
        return $produtos;
    }
}
?>
