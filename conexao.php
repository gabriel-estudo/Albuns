<?php

// Conexão com o banco (MySQL)  DESENVOLVIMENTO
// $host = "localhost";
// $usuario = "root";
// $senha = "";
// $banco = "albuns";

// Conexão com o banco (MySQL)  PRODUÇÃO
$host = "www.gabrielmil.com.br";
$usuario = "gabrielmil";
$senha = "Gabriel@230107";
$banco = "gabrielmil01";

$conexao = new mysqli($host, $usuario, $senha, $banco);

// Verifica conexão
if ($conexao->connect_error) {
    echo json_encode(["status" => "erro", "mensagem" => "Falha na conexão: " . $conexao->connect_error]);
    exit;
}
