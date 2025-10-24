<?php
header("Content-Type: application/json; charset=UTF-8");

include_once "conexao.php";

// Recebe dados do formulário
$nome  = $_POST['frmNome'] ?? '';
$nac_int  = $_POST['nac_int'] ?? '';
$nota  = $_POST['frmNota'] ?? '';

// Validação simples
if (empty($nome)) {
    echo json_encode(["status" => "erro", "mensagem" => "Preencha o nome."]);
    exit;
}

if (empty($nota)) {
    echo json_encode(["status" => "erro", "mensagem" => "Preencha a nota."]);
    exit;
}

// Prepara e executa inserção segura
$stmt = $conexao->prepare("INSERT INTO bandas (nome, nac_int, nota) VALUES (?, ?, ?)");
$stmt->bind_param("sis", $nome, $nac_int, $nota);

if ($stmt->execute()) {
    $id = $stmt->insert_id;

    // fazendo upload da foto
    if (isset($_FILES['frmFoto'])) {
        $caminho = "img/";
        $novoNome = "banda_" . $id . ".png";
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

    echo json_encode(["status" => "sucesso", "id" => $stmt->insert_id]);
} else {
    echo json_encode(["status" => "erro", "mensagem" => "Erro ao inserir: " . $stmt->error]);
}

$stmt->close();
$conexao->close();
