<?php
header("Content-Type: application/json; charset=UTF-8");

include_once "conexao.php";

// Recebe dados do formulário
$banda_id  = $_POST['frmBandaId'] ?? '';
$localShow  = $_POST['frmLocal'] ?? '';
$dataShow  = $_POST['frmData'] ?? '';

// Validação simples
if (empty($banda_id)) {
    echo json_encode(["status" => "erro", "mensagem" => "Preencha a banda."]);
    exit;
}

if (empty($localShow)) {
    echo json_encode(["status" => "erro", "mensagem" => "Preencha o local."]);
    exit;
}

if (empty($dataShow)) {
    echo json_encode(["status" => "erro", "mensagem" => "Preencha a data."]);
    exit;
}

// Prepara e executa inserção segura
$stmt = $conexao->prepare("INSERT INTO shows (banda_id, local, data) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $banda_id, $localShow, $dataShow);

if ($stmt->execute()) {
    $id = $stmt->insert_id;

    echo json_encode(["status" => "sucesso", "id" => $stmt->insert_id]);
} else {
    echo json_encode(["status" => "erro", "mensagem" => "Erro ao inserir: " . $stmt->error]);
}

$stmt->close();
$conexao->close();
