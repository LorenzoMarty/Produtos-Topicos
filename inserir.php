<?php

require_once "conexao.php";
$conexao = conectar();

// Recebe o JSON enviado
$produto = json_decode(file_get_contents("php://input"));

// Verifica se os dados básicos do produto foram recebidos
if (!empty($produto->nome) && !empty($produto->descricao) && !empty($produto->preco)) {
    // Inicializa o caminho da imagem como uma string vazia (caso não tenha imagem)
    $caminhoImagem = "";

    // Se a imagem foi enviada, processa e salva
    if (!empty($produto->imagem)) {
        // Extrai o conteúdo da imagem (removendo "data:image/...;base64,")
        list($tipo, $dadosImagem) = explode(';', $produto->imagem);
        list(, $dadosImagem) = explode(',', $dadosImagem);
        $dadosImagem = base64_decode($dadosImagem);

        // Gera um nome único para a imagem e define o diretório de upload
        $nomeImagem = uniqid() . '.png';
        $caminhoImagem = 'img/produtos/' . $nomeImagem;

        // Salva a imagem no servidor
        if (!file_put_contents($caminhoImagem, $dadosImagem)) {
            echo json_encode(["erro" => "Falha ao salvar a imagem no servidor."]);
            exit;
        }
    }

    // Insere os dados do produto no banco de dados usando prepared statements
    $sql = "INSERT INTO produtos (nome, descricao, preco, imagem) VALUES (?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);

    if ($stmt) {
        // Corrige o tipo de 'preco' para 'd' (double) e 'imagem' para string
        $stmt->bind_param("ssds", $produto->nome, $produto->descricao, $produto->preco, $caminhoImagem);

        // Executa a consulta e verifica se foi bem-sucedida
        if ($stmt->execute()) {
            // Recupera o ID gerado para o produto e o adiciona ao objeto
            $produto->id_produto = $stmt->insert_id;

            // Se a imagem foi salva, atualiza o objeto de produto com o caminho da imagem
            if (!empty($caminhoImagem)) {
                $produto->imagem = $caminhoImagem;
            }

            echo json_encode($produto);
        } else {
            echo json_encode(["erro" => "Erro ao inserir o produto no banco de dados."]);
        }
        $stmt->close();
    } else {
        echo json_encode(["erro" => "Erro ao preparar a consulta."]);
    }
} else {
    echo json_encode(["erro" => "Dados do produto incompletos."]);
}

$conexao->close();
