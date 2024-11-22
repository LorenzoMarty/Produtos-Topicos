<?php

require_once "conexao.php";
$conexao = conectar();

$produto = json_decode(file_get_contents("php://input"));

// Decodifica e salva a imagem se ela for enviada
if (!empty($produto->imagem)) {
        // Extrai o conteúdo da imagem (removendo "data:image/...;base64,")
        list($tipo, $dadosImagem) = explode(';', $produto->imagem);
        list(, $dadosImagem) = explode(',', $dadosImagem);
        $dadosImagem = base64_decode($dadosImagem);

        // Gera um nome único para a imagem e define o diretório de upload
        $nomeImagem = uniqid() . '.png';
        $caminhoImagem = 'img/produtos/' . $nomeImagem;

        // Salva a imagem no servidor
        file_put_contents($caminhoImagem, $dadosImagem);
} else {
        // Mantém a imagem antiga se uma nova não for enviada
        $caminhoImagem = $produto->imagem_atual ?? null;
}

// Prepara e executa a consulta para atualização do produto
$sql = "UPDATE produtos SET
        nome = ?, 
        descricao = ?, 
        preco = ?, 
        imagem = ?
        WHERE id_produto = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param(
        "ssdsi",
        $produto->nome,
        $produto->descricao,
        $produto->preco,
        $caminhoImagem,
        $produto->id_produto
);

if ($stmt->execute()) {
        $produto->imagem = $caminhoImagem;
        echo json_encode($produto);
} else {
        echo json_encode(["erro" => "Erro ao atualizar o produto."]);
}

$stmt->close();
$conexao->close();
