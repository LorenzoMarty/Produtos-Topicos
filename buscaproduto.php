<?php

$id_produto = $_GET['id_produto'];

require_once "conexao.php";
$conexao = conectar();

$sql = "SELECT id_produto, nome, descricao, imagem, preco FROM produtos 
        WHERE id_produto = $id_produto";
$resultado = executarSQL($conexao, $sql);
$produtos = mysqli_fetch_assoc($resultado);
echo json_encode($produtos);
