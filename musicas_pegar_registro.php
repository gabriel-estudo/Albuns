<?php
header("Content-Type: application/json; charset=UTF-8");

include_once "conexao.php";

// Recebe dado
$id  = $_GET['id'] ?? '';

// Consulta
$stmt = $conexao->prepare("SELECT * FROM musicas WHERE id = $id");

if ($stmt->execute()) {
    $resultado = $stmt->get_result();

    // Converte para array associativo
    $registro = $resultado->fetch_all(MYSQLI_ASSOC);

    echo json_encode(["status" => "sucesso", "registro" => $registro]);
} else {
    echo json_encode(["status" => "erro", "mensagem" => "Erro ao consultar: " . $stmt->error]);
}

$stmt->close();
$conexao->close();
