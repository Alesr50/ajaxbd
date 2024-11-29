<?php

include "conexao.php";

try {
    // Recebe os dados via POST e faz a sanitização básica
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha']; // A senha será hashada mais tarde

    // Verifica se todos os campos foram preenchidos
    if (!$nome || !$email || !$senha) {
        echo json_encode(["success" => false, "error" => "Preencha todos os campos!"]);
        exit;
    }

    // Hash da senha
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // Prepara a consulta SQL com placeholders nomeados para maior clareza
    $sql = "INSERT INTO usuario (NOME, EMAIL, SENHA) VALUES (:nome, :email, :senha)";
    $stmt = $pdo->prepare($sql);

    // Vincula os parâmetros de forma segura
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senhaHash);

    // Executa a consulta
    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Erro ao salvar usuário."]);
    }
} catch (Exception $e) {
    // Captura e exibe erros
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}

