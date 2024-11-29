<?php

include "conexao.php";

try {
    // Recebe os dados via POST e faz a sanitização básica
    $idP = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    
    // Verifica se todos os campos foram preenchidos

    // Prepara a consulta SQL com placeholders nomeados para maior clareza
    $sql = "DELETE FROM PRODUTO WHERE ID_PRODUTO=:id";
    $stmt = $pdo->prepare($sql);

    // Vincula os parâmetros de forma segura
    $stmt->bindParam(':id', $idP);

    // Executa a consulta
    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Erro ao apagar produto Produto."]);
    }
} catch (Exception $e) {
    // Captura e exibe erros
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}

