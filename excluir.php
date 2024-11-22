<?php

$id_produto = $_GET['id_produto'];

require_once "conexao.php";
$conexao = conectar();

// Busca o caminho da imagem associada ao produto
$sqlImagem = "SELECT imagem FROM produtos WHERE id_produto = ?";
$stmtImagem = $conexao->prepare($sqlImagem);
$stmtImagem->bind_param("i", $id_produto);
$stmtImagem->execute();
$stmtImagem->bind_result($caminhoImagem);
$stmtImagem->fetch();
$stmtImagem->close();

// Verifica se a imagem existe e a exclui do servidor
if ($caminhoImagem && file_exists($caminhoImagem)) {
    unlink($caminhoImagem);
}

// Exclui o produto do banco de dados
$sql = "DELETE FROM produtos WHERE id_produto = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_produto);
$retorno = $stmt->execute();
$stmt->close();

echo json_encode($retorno);

$conexao->close();
