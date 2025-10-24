<?php
header("Content-Type: application/json; charset=UTF-8");

include_once "conexao.php";

// Recebe dados do formulário
$id = $_POST['frmId'] ?? '';
$banda_id  = $_POST['frmBandaId'] ?? '';
$nome  = $_POST['frmNome'] ?? '';
$nota  = $_POST['frmNota'] ?? '';

// Validação simples
if (empty($banda_id)) {
    echo json_encode(["status" => "erro", "mensagem" => "Preencha a banda."]);
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

// Prepara e executa o update seguro
$stmt = $conexao->prepare("UPDATE albuns SET banda_id = ?, nome = ?, nota = ? WHERE id = ?");
$stmt->bind_param("isii", $banda_id, $nome, $nota, $id);

if ($stmt->execute()) {
    // fazendo upload da foto
    if (isset($_FILES['frmFoto'])) {
        $caminho = "img/";
        $novoNome = "album_" . $id . ".png";
        $caminhoFinal = $caminho . $novoNome;
        $extensao = strtolower(pathinfo($_FILES['frmFoto']['name'], PATHINFO_EXTENSION));

        // converte jpg e jpeg para png se necessario
        if ($extensao === "jpg" || $extensao === "jpeg") {
            $imagem = imagecreatefromjpeg($_FILES['frmFoto']['tmp_name']);
            imagepng($imagem, $caminhoFinal);
            imagedestroy($imagem);
        } else {
            move_uploaded_file($_FILES['frmFoto']['tmp_name'], $caminhoFinal);
        }
    }

    echo json_encode(["status" => "sucesso", "id" => $id]);
} else {
    echo json_encode(["status" => "erro", "mensagem" => "Erro ao atualizar: " . $stmt->error]);
}

$stmt->close();
$conexao->close();
