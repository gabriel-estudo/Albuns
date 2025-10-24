<?php
header("Content-Type: application/json; charset=UTF-8");

include_once "conexao.php";

// Recebe dados do formulário
$id = $_POST['frmId'] ?? '';
$album_id  = $_POST['frmAlbumId'] ?? '';
$nome  = $_POST['frmNome'] ?? '';
$nota  = $_POST['frmNota'] ?? '';
$duracao  = $_POST['frmDuracao'] ?? '';

// Validação simples
if (empty($album_id)) {
    echo json_encode(["status" => "erro", "mensagem" => "Preencha o album."]);
    exit;
}

if (empty($nome)) {
    echo json_encode(["status" => "erro", "mensagem" => "Preencha o nome."]);
    exit;
}

if (empty($nota)) {
    echo json_encode(["status" => "erro", "mensagem" => "Preencha a nota."]);
    exit;
}

if (empty($duracao)) {
    echo json_encode(["status" => "erro", "mensagem" => "Preencha a duração."]);
    exit;
} else {
    if (preg_match('/^([0-9]{2}):([0-5][0-9]):([0-5][0-9])$/', $duracao) === 0) {
        echo json_encode(["status" => "erro", "mensagem" => "Duração invalida."]);
        exit;
    }
}

// Prepara e executa o update seguro
$stmt = $conexao->prepare("UPDATE musicas SET album_id = ?, nome = ?, nota = ?, duracao = ? WHERE id = ?");
$stmt->bind_param("isisi", $album_id, $nome, $nota, $duracao, $id);

if ($stmt->execute()) {
    echo json_encode(["status" => "sucesso", "id" => $id]);
} else {
    echo json_encode(["status" => "erro", "mensagem" => "Erro ao atualizar: " . $stmt->error]);
}

$stmt->close();
$conexao->close();
