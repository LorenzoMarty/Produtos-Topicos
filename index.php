<!DOCTYPE html>
<html lang="pt_BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD JS</title>
    <!-- Importa o Materialize CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
    <style>
        .navbar {
            background-color: #1565c0;
            color: white;
        }
        .products-title {
            text-align: center;
            margin: 20px 0;
            font-family: 'Poppins', sans-serif;
        }
        .card-title {
            font-size: 1.1rem;
            font-weight: bold;
        }
    </style>
</head>

<body>
<nav class="navbar">
        <div class="nav-wrapper container">
            <a href="#" class="brand-logo center">SuperTudo</a>
            <ul class="right hide-on-med-and-down">
                <li><b><a href="main.php">CRUD</a></b></li>
            </ul>
        </div>
    </nav>

    <!-- Título dos Produtos -->
    <h5 class="products-title">Produtos do SuperTudo</h5>

    <!-- Grid de Produtos -->
    <div class="container">
        <div class="row">
            <?php
            require_once "conexao.php";
            $conexao = conectar();

            // Consulta para buscar 8 produtos aleatórios
            $sql = "SELECT nome FROM produtos ORDER BY RAND() LIMIT 8";
            $result = executarSQL($conexao, $sql);

            // Verifica se há produtos
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '
                        <div class="col s12 m6 l3">
                            <div class="card">
                                <div class="card-content">
                                    <span class="card-title">' . htmlspecialchars($row['nome']) . '</span>
                                </div>
                            </div>
                        </div>
                    ';
                }
            } else {
                echo '<p class="center-align">Nenhum produto encontrado.</p>';
            }

            // Fecha a conexão
            $conexao->close();
            ?>
        </div>
    </div>

    <!-- Importa o Materialize JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>

</html>