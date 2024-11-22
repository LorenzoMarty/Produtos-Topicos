<?php
require_once "conexao.php";
$conexao = conectar();

$sql = "SELECT nome, imagem, preco FROM produtos ORDER BY RAND() LIMIT 8";
$result = executarSQL($conexao, $sql);

if ($result->num_rows > 0) {
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    for ($row = 0; $row < 2; $row++) {
        echo '<div class="row">';
        for ($col = 0; $col < 4; $col++) {
            $index = $row * 4 + $col;
            echo '
                <div class="col s12 m6 l3">
                    <div class="card">
                        <div class="card-image">
                            <img src="' . htmlspecialchars($products[$index]['imagem']) . '" alt="' . htmlspecialchars($products[$index]['nome']) . '">
                        </div>
                        <div class="card-content">
                            <span class="card-title">' . htmlspecialchars($products[$index]['nome']) . '</span>
                            <p class="card-price">R$ ' . number_format($products[$index]['preco'], 2, ',', '.') . '</p>
                        </div>
                    </div>
                </div>
            ';
        }
        echo '</div>';
    }
} else {
    echo '<p class="center-align">Nenhum produto encontrado.</p>';
}

$conexao->close();
?>
