<?php
header("Content-Type: application/json; charset=UTF-8");

include_once "conexao.php";

// Recebe dados do formulário
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

// Prepara e executa inserção segura
$stmt = $conexao->prepare("INSERT INTO musicas (album_id, nome, nota, duracao) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isis", $album_id, $nome, $nota, $duracao);

if ($stmt->execute()) {
    $id = $stmt->insert_id;

    echo json_encode(["status" => "sucesso", "id" => $id]);
} else {
    echo json_encode(["status" => "erro", "mensagem" => "Erro ao inserir: " . $stmt->error]);
}

$stmt->close();
$conexao->close();
