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
        <title>Loja</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <style>
            body {
                background-color: #121212; /* Fundo preto */
                color: #ffffff; /* Texto branco */
                font-family: 'Poppins', sans-serif;
            }
            header {
                background-color: #1f1f1f; /* Fundo escuro do cabeçalho */
                box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
                position: sticky;  /* Adiciona a posição sticky */
                top: 0;  /* Fixa no topo */
                z-index: 1050;  /* Garante que o navbar tenha prioridade sobre outros elementos */
                width: 100%;
            }
            .nav-brand {
                width: 140px;
                height: 100px;
            }
            .card {
                background-color: #1f1f1f; /* Fundo escuro para os cards */
                border-radius: 10px;
                transition: transform 0.3s ease;
            }
            .card:hover {
                transform: scale(1.05);
            }
            .card-img-top {
                border-top-left-radius: 10px;
                border-top-right-radius: 10px;
                height: 300px;
                object-fit: cover;
            }
            .card-text {
                color: #64ffda; /* Texto verde para as informações do produto */
                font-weight: bold;
            }
            .card-title{
                color: #ffffff; /* Títulos brancos */
            }
            .btn-primary {
                background-color: #64ffda; /* Cor do botão em verde */
                border: none;
                color: #121212; /* Cor do texto do botão */
                font-weight: bold;
                transition: 0.3s;
            }
            .btn-primary:hover {
                background-color: #52e0c4; /* Efeito hover mais claro */
            }
            .perfil-container {
                position: relative;
                display: inline-block;
            }
            .dropdown-menu {
                display: none;
                position: absolute;
                right: 0;
                background-color: #1f1f1f; /* Fundo escuro para o dropdown */
                color: white;
                box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
                border-radius: 8px;
                width: 150px;
                padding: 10px;
                z-index: 10;
            }
            .dropdown-menu a {
                color: white; /* Cor do texto no dropdown */
                text-decoration: none;
                display: block;
                padding: 8px;
                border-radius: 5px;
            }
            .dropdown-menu a:hover {
                background-color: #64ffda; /* Efeito de hover para os itens do dropdown */
                color: #121212;
            }
            footer {
                background-color: #1f1f1f; /* Fundo escuro para o rodapé */
                text-align: center;
                padding: 10px;
            }
            p {
                color: #ffffff; /* Texto branco no rodapé */
            }
        </style>
    </head>
    <body>
        <header>
            <nav class="navbar navbar-expand-lg sticky-top">
                <div class="container">
                    <img src="assets/cm3.png" class="nav-brand me-auto">
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
                    <a href="carrinho.php" class="ms-3">
                        <i class="fa-solid fa-cart-shopping fa-2x" style="color: white"></i>
                    </a>
                </div>
            </nav>
        </header>
        <main>
            <section>
                <div class="container py-5">
                    <div class="row g-4">
                        <?php 
                        $produtos = [
                            ["img" => "assets/galaxys23.png", "nome" => "Samsung Galaxy S23", "preco" => "3500.00", "estoque" => 50],
                            ["img" => "assets/notebook.jpg", "nome" => "Notebook Dell Inspiron 15", "preco" => "4800.00", "estoque" => 30],
                            ["img" => "assets/lg50.avif", "nome" => "Televisão LG 50\" 4K", "preco" => "3500.00", "estoque" => 40],
                            ["img" => "assets/jbl.webp", "nome" => "Fone de Ouvido JBL", "preco" => "500.00", "estoque" => 100],
                            ["img" => "assets/camera.jpg", "nome" => "Câmera Digital Canon EOS R5", "preco" => "16000.00", "estoque" => 15],
                            ["img" => "assets/relogio.jpg", "nome" => "Smartwatch Apple Watch Series 8", "preco" => "3500.00", "estoque" => 25]
                        ];
                        foreach ($produtos as $produto) { ?>
                        <div class="col-md-4">
                            <div class="card">
                                <img class="card-img-top" src="<?php echo $produto['img']; ?>" alt="<?php echo $produto['nome']; ?>">
                                <div class="card-body text-center">
                                    <h5 class="card-title"><?php echo $produto['nome']; ?></h5>
                                    <p class="card-text">R$<?php echo $produto['preco']; ?></p>
                                    <p>Em estoque: <?php echo $produto['estoque']; ?></p>
                                    <a href="#" class="btn btn-primary">Adicionar ao Carrinho</a>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </section>
        </main>
        <footer>
            <p>&copy; 2025 CM3 - Todos os direitos reservados</p>
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
