<!DOCTYPE html>
<html lang="pt_BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuperTudo</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="img/icon.png" type="image/x-icon">
    <style>
        .navbar {
            background: linear-gradient(90deg, #0d47a1, #1565c0);
            color: white;
        }

        .navbar .brand-logo {
            font-family: 'Poppins', sans-serif;
            font-size: 1.8rem;
            font-weight: 600;
        }

        .navbar a {
            color: white !important;
            font-weight: 500;
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
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="nav-wrapper container">
            <a href="#" class="brand-logo center">SuperTudo</a>
            <ul class="right">
                <li><a href="main.php">CRUD</a></li>
            </ul>
        </div>
    </nav>
    <h5 class="products-title">Explore os Produtos do SuperTudo</h5>
    <div class="container">
        <div class="row" id="product-grid">
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        function loadProducts() {
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "produtos.php", true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    document.getElementById("product-grid").innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }
        setInterval(loadProducts, 5000);
        loadProducts();
    </script>
</body>

</html>
