<?php

// Conexão com o banco (MySQL)
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "albuns";

$conexao = new mysqli($host, $usuario, $senha, $banco);

// Verifica conexão
if ($conexao->connect_error) {
    echo json_encode(["status" => "erro", "mensagem" => "Falha na conexão: " . $conexao->connect_error]);
    exit;
}
