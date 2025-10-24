<?php
header("Content-Type: application/json; charset=UTF-8");
include_once "conexao.php";

$registro_banda = [];
$registro_album = [];
$registro_musica = [];
$registro_show = [];

// Consulta melhor banda
$stmt_banda = $conexao->prepare("SELECT * FROM bandas ORDER BY nota DESC LIMIT 1");
if ($stmt_banda && $stmt_banda->execute()) {
    $resultado_banda = $stmt_banda->get_result();
    $registro_banda = $resultado_banda->fetch_assoc(); // apenas um registro
}

// Consulta melhor album
$stmt_album = $conexao->prepare("SELECT * FROM albuns ORDER BY nota DESC LIMIT 1");
if ($stmt_album && $stmt_album->execute()) {
    $resultado_album = $stmt_album->get_result();
    $registro_album = $resultado_album->fetch_assoc(); // apenas um registro
}

// Consulta melhor musica
$stmt_musica = $conexao->prepare("SELECT * FROM musicas ORDER BY nota DESC LIMIT 1");
if ($stmt_musica && $stmt_musica->execute()) {
    $resultado_musica = $stmt_musica->get_result();
    $registro_musica = $resultado_musica->fetch_assoc(); // apenas um registro
}

// Consulta ultimo show
$stmt_show = $conexao->prepare("SELECT * FROM shows ORDER BY 'data' DESC LIMIT 1");
if ($stmt_show && $stmt_show->execute()) {
    $resultado_show = $stmt_show->get_result();
    $registro_show = $resultado_show->fetch_assoc(); // apenas um registro
}

echo json_encode([
    "status" => "sucesso",
    "banda" => $registro_banda,
    "album" => $registro_album,
    "musica" => $registro_musica,
    "show" => $registro_show
]);

$stmt_banda->close();
$stmt_album->close();
$stmt_musica->close();
$stmt_show->close();
$conexao->close();
