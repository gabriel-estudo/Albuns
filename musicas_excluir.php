<?php
header("Content-Type: application/json; charset=UTF-8");

include_once "conexao.php";

// Recebe dados do formulário
$id = $_GET['id'] ?? '';

// Excluir registro
$stmt = $conexao->prepare("DELETE FROM musicas WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(["status" => "sucesso"]);
} else {
    echo json_encode(["status" => "erro", "mensagem" => "Erro ao excluir: " . $stmt->error]);
}

$stmt->close();
$conexao->close();
