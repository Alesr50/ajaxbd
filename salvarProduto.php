<?php

include "conexao.php";

try {
    // Recebe os dados via POST e faz a sanitização básica
    $nome = filter_input(INPUT_POST, 'nomeProduto', FILTER_SANITIZE_STRING);
    $valor = filter_input(INPUT_POST, 'valorProduto', FILTER_SANITIZE_NUMBER_FLOAT);
    $marca = filter_input(INPUT_POST, 'marca', FILTER_SANITIZE_STRING);

    // Verifica se todos os campos foram preenchidos
    if (!$nome || !$valor || !$marca) {
        echo json_encode(["success" => false, "error" => "Preencha todos os campos!",
    $nome,$valor,$marca]);
        exit;
    }


    // Prepara a consulta SQL com placeholders nomeados para maior clareza
    $sql = "INSERT INTO PRODUTO (NOME, VALOR, MARCA) VALUES (:nome, :valor, :marca)";
    $stmt = $pdo->prepare($sql);

    // Vincula os parâmetros de forma segura
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':valor', $valor);
    $stmt->bindParam(':marca', $marca);

    // Executa a consulta
    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Erro ao salvar Produto."]);
    }
} catch (Exception $e) {
    // Captura e exibe erros
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}

