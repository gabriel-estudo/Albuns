<?php
header("Content-Type: application/json; charset=UTF-8");

include_once "conexao.php";

// Recebe dados do formulário
$id = $_POST['frmId'] ?? '';
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

// Prepara e executa o update seguro
$stmt = $conexao->prepare("UPDATE shows SET banda_id = ?, local = ?, data = ? WHERE id = ?");
$stmt->bind_param("issi", $banda_id, $localShow, $dataShow, $id);

if ($stmt->execute()) {
    echo json_encode(["status" => "sucesso", "id" => $id]);
} else {
    echo json_encode(["status" => "erro", "mensagem" => "Erro ao atualizar: " . $stmt->error]);
}

$stmt->close();
$conexao->close();
