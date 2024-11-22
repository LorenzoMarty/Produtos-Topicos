<?php

require_once "conexao.php";
$conexao = conectar();

$sql = "SELECT * FROM produtos";
$resultado = executarSQL($conexao, $sql);
$produtos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
echo json_encode($produtos);
