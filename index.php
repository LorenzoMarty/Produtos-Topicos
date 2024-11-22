<!DOCTYPE html>
<html lang="pt_BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuperTudo</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="shortcut icon" href="img/icon.png" type="image/x-icon">
    <style>
        body {
            background-color: #f5f5f5;
        }

        .navbar {
            background: white;
            color: #0d47a1;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar .brand-logo {
            font-family: 'Poppins', sans-serif;
            font-size: 1.8rem;
            font-weight: 600;
            color: #0d47a1 !important;
        }

        .navbar a {
            color: #0d47a1 !important;
            font-weight: 500;
        }

        .sidenav {
            background: #0d47a1;
        }

        .sidenav a {
            color: white !important;
            font-weight: bold;
        }

        .products-title {
            text-align: center;
            margin: 30px 0;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            color: #333;
        }

        .card {
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .card-image img {
            border-bottom: 3px solid #1565c0;
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
        }

        .card-content {
            text-align: center;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: bold;
            font-family: 'Poppins', sans-serif;
            color: #1565c0;
        }

        .card-price {
            font-size: 1rem;
            color: #4caf50;
            font-weight: bold;
            margin-top: 5px;
        }

        .card-action a {
            margin-right: 10px;
            border-radius: 5px;
        }

        footer.page-footer {
            background: white;
            color: #0d47a1;
            box-shadow: 0 -4px 6px rgba(0, 0, 0, 0.1);
        }

        footer.page-footer h5,
        footer.page-footer p,
        footer.page-footer a {
            color: #0d47a1 !important;
        }

        .footer-copyright {
            background: white;
            color: #0d47a1;
            padding: 10px 0;
        }

        footer.page-footer ul li a {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        @media (max-width: 600px) {
            .card-title {
                font-size: 1rem;
            }

            .card-price {
                font-size: 0.9rem;
            }
        }

        .container {
            margin-bottom: 50px;
        }

        .progress {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="nav-wrapper container">
            <a href="#" class="brand-logo center"><img src="img/icon.png" width="32px" height="32px" alt="">SuperTudo</a>
            <a href="#" data-target="mobile-nav" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
                <li><a href="main.php">CRUD</a></li>
            </ul>
        </div>
    </nav>

    <ul class="sidenav" id="mobile-nav">
        <li><a href="main.php">CRUD</a></li>
    </ul>

    <h5 class="products-title">Explore os Produtos do SuperTudo</h5>
    <div class="container">
        <div class="row" id="product-grid">
            <div class="progress">
                <div class="indeterminate"></div>
            </div>
            <p class="center-align">Carregando produtos...</p>
        </div>
        <div class="center-align">
            <button class="btn blue darken-4" onclick="loadProducts()">Atualizar Produtos</button>
        </div>
    </div>

    <footer class="page-footer">
        <div class="container">
            <div class="row">
                <div class="col l6 s12">
                    <h5>SuperTudo</h5>
                    <p>Descubra e gerencie produtos de forma prática e eficiente.</p>
                </div>
                <div class="col l4 offset-l2 s12">
                    <h5>Links</h5>
                    <ul>
                        <li><a href="#!"><i class="material-icons left">security</i>Política de Privacidade</a></li>
                        <li><a href="#!"><i class="material-icons left">gavel</i>Termos de Uso</a></li>
                        <li><a href="#!"><i class="material-icons left">contact_mail</i>Contato</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">
                <p>© 2024 SuperTudo - Todos os direitos reservados.</p>
                <a class="right" href="#!">Sobre Nós</a>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var sidenavs = document.querySelectorAll('.sidenav');
            M.Sidenav.init(sidenavs);
        });

        function loadProducts() {
            const productGrid = document.getElementById("product-grid");
            productGrid.innerHTML = `
                <div class="progress">
                    <div class="indeterminate"></div>
                </div>
                <p class="center-align">Carregando produtos...</p>
            `;

            const xhr = new XMLHttpRequest();
            xhr.open("GET", "produtos.php", true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    productGrid.innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }

        loadProducts();
    </script>
</body>

</html>
