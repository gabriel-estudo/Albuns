<?php
header("Content-Type: application/json; charset=UTF-8");

include_once "conexao.php";

// Consulta
$stmt = $conexao->prepare("SELECT * FROM bandas ORDER BY nota DESC");

if ($stmt->execute()) {
    $resultado = $stmt->get_result();

    // Converte para array associativo
    $registros = $resultado->fetch_all(MYSQLI_ASSOC);

    echo json_encode(["status" => "sucesso", "registros" => $registros]);
} else {
    echo json_encode(["status" => "erro", "mensagem" => "Erro ao consultar: " . $stmt->error]);
}

$stmt->close();
$conexao->close();
