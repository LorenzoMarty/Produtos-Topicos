<!DOCTYPE html>
<html lang="pt_BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
    <!-- Importa o Materialize CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
    <style>
        .navbar {
            background-color: #1565c0;
            color: white;
        }

        img.responsive-img {
            max-height: 100px;
            object-fit: contain;
        }

        .img-tabela {
            max-width: 50px;
            max-height: 50px;
            object-fit: contain;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="nav-wrapper container">
            <a href="#" class="brand-logo center">SuperTudo</a>
            <ul class="right hide-on-med-and-down">
                <li><b><a href="index.php">Inicio</a></b></li>
            </ul>
        </div>
    </nav>

    <!-- Formulário e Tabela -->
    <div class="container">
        <div class="row">
            <!-- Formulário -->
            <div class="col s12 m6">
                <form onsubmit="return salvarProduto(event);" class="card-panel">
                    <h5>Cadastro de Produtos</h5>
                    <div class="input-field">
                        <input type="number" name="id_produto" id="id_produto" readonly>
                        <label for="id_produto">ID</label>
                    </div>
                    <div class="input-field">
                        <input type="text" name="nome" id="nome" required>
                        <label for="nome">Nome</label>
                    </div>
                    <div class="input-field">
                        <input type="text" name="descricao" id="descricao" required>
                        <label for="descricao">Descrição</label>
                    </div>
                    <div class="input-field">
                        <input type="text" name="preco" id="preco" required>
                        <label for="preco">Preço</label>
                    </div>
                    <div class="file-field input-field">
                        <div class="btn blue darken-4">
                            <span>Imagem</span>
                            <input type="file" name="imagem" id="imagem">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>
                    <button type="submit" class="btn waves-effect waves-light blue darken-4">
                        Salvar Produto
                    </button>
                    <button id="btn-gerar-pdf" class="btn green darken-4">Gerar PDF</button>
                </form>
            </div>

            <!-- Tabela -->
            <div class="col s12 m6">
                <table class="responsive-table highlight centered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Preço</th>
                            <th>Imagem</th>
                            <th>Opções</th>
                        </tr>
                    </thead>
                    <tbody id="produtos"></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmação -->
    <div id="modal-confirmacao" class="modal">
        <div class="modal-content">
            <h4>Confirmar Exclusão</h4>
            <p>Você tem certeza que deseja excluir este produto?</p>
        </div>
        <div class="modal-footer">
            <button id="btn-cancelar-exclusao" class="modal-close btn">Cancelar</button>
            <button id="btn-confirmar-exclusao" class="btn red darken-4">Confirmar</button>
        </div>
    </div>

    <!-- Importa Materialize JavaScript e o Script Principal -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="script.js"></script>
    <script>
        // Inicializa o modal
        document.addEventListener('DOMContentLoaded', function () {
            var modals = document.querySelectorAll('.modal');
            M.Modal.init(modals);
        });
    </script>
</body>

</html>