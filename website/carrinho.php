<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
?>

<!doctype html>
<html lang="pt-br">
    <head>
        <title>Carrinho</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

        <!-- Bootstrap CSS v5.2.1 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    </head>
    <style>
    body {
        background-color: #121212;
        color: #e0e0e0;
        font-family: 'Poppins', sans-serif;
    }

    header {
        background-color: #1f1f1f;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        position: sticky;
        top: 0;
        z-index: 1050;
        width: 100%;
    }

    .nav-brand {
        width: 140px;
        height: 100px;
    }

    .navbar-toggler-icon {
        font-size: 20px;
    }

    ul {
        font-size: 20px;
    }

    footer {
        background-color: #1e1e1e;
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        width: 100%;
        height: 100px;
        text-align: center;
        color: white;
        line-height: 60px;
    }

    .card {
        background-color: #333;
        border: none;
        color: #e0e0e0;
    }

    .card-header {
        background-color: #444;
    }

    .card-body {
        background-color: #555;
    }

    /* Ajuste de alinhamento e estilo do ícone de perfil */
    .perfil-container {
        position: relative;
        display: flex;
        align-items: center;
    }

    .perfil-container a {
        cursor: pointer;
    }
    .perfil-container i {
    margin-right: 10px; /* Ajuste o valor para o espaçamento desejado */
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        top: 40px;
        right: 0;
        background-color: #333;
        color: #fff;
        padding: 10px;
        border-radius: 5px;
        width: 200px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    }

    .dropdown-menu a {
        color: #fff;
        text-decoration: none;
        display: block;
        padding: 8px;
        border-bottom: 1px solid #444;
    }

    .dropdown-menu a:hover {
        background-color: #444;
    }

    .dropdown-menu p {
        margin: 0;
        padding-bottom: 5px;
    }

    .dropdown-menu hr {
        margin: 5px 0;
        border: 0;
        border-top: 1px solid #444;
    }

    /* Ajuste para alinhar o ícone da casa */
    .navbar-nav a {
        display: flex;
        align-items: center;
    }
    </style>

    <body>
        <header>
            <nav class="navbar navbar-expand-lg sticky-top">
                <div class="container">
                    <img src="assets/cm3.png" class="nav-brand me-auto">
                    <div class="ms-auto d-flex align-items-center">
                        <div class="ms-auto perfil-container">
                            <a href="#" onclick="toggleDropdown(event)">
                                <i class="fa-solid fa-circle-user fa-2x" style="color: #ffffff;"></i>
                            </a>
                            <div class="dropdown-menu" id="dropdown">
                                <p>👤 <strong><?php echo isset($_SESSION['nome']) ? $_SESSION['nome'] : 'Usuário'; ?></strong></p>
                                <hr>
                                <a href="logout.php">Sair</a>
                            </div>
                        </div>
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a href="painel.php" class="nav-link">
                                    <i class="fa-solid fa-house fa-xl" style="color: white"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <main>
            <div class="container text-center mt-5">
                <h2 class="fw-bold mt-2" style="color: white">Seu carrinho</h2>
                
                <div class="p-4 mt-5" style="background-color: #121212;">
                    <img src="https://www.havan.com.br/static/version1743118210/frontend/Havan/themeDefault/pt_BR/images/svg/empty-cart-img.svg" 
                        alt="Empty cart" width="150" class="mx-auto d-block">

                    <p class="fw-bold mt-3 text-white">Você não possui nenhum item em seu carrinho de compras.</p>
                    <p class="text-white">Vamos explorar inúmeras ofertas e encontrar uma ideal para você.</p>
                </div>
            </div>
        </main>
        <footer>
            <div class="container px-5"><p class="m-0 text-center text-white">&copy; 2025 CM3 - Todos os direitos reservados</p></div>
        </footer>
        <script>
            function toggleDropdown(event) {
                event.preventDefault();
                var dropdown = document.getElementById("dropdown");
                dropdown.style.display = (dropdown.style.display === "block") ? "none" : "block";
            }
            document.addEventListener("click", function(event) {
                var dropdown = document.getElementById("dropdown");
                if (!event.target.closest(".perfil-container")) {
                    dropdown.style.display = "none";
                }
            });
        </script>
    </body>
</html>
