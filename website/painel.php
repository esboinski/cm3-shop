<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

require_once 'conexao.php';
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
            background-color: #121212;
            color: #ffffff;
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

        .card {
            background-color: #1f1f1f;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
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
            color: #64ffda;
            font-weight: bold;
        }

        .card-title {
            color: #ffffff;
        }

        .btn-primary {
            background-color: #64ffda;
            border: none;
            color: #121212;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background-color: #52e0c4;
        }

        .perfil-container {
            position: relative;
            display: inline-block;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            background-color: #1f1f1f;
            color: white;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            width: 150px;
            padding: 10px;
            z-index: 10;
        }

        .dropdown-menu a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 8px;
            border-radius: 5px;
        }

        .dropdown-menu a:hover {
            background-color: #64ffda;
            color: #121212;
        }

        footer {
            background-color: #1f1f1f;
            text-align: center;
            padding: 10px;
        }

        p {
            color: #ffffff;
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
                    // Mapear imagens por ID
                    $imagens = [
                        1 => "galaxys23.png",
                        2 => "notebook.jpg",
                        3 => "lg50.avif",
                        4 => "jbl.webp",
                        5 => "camera.jpg",
                        6 => "relogio.jpg"
                    ];

                    $sql = "SELECT id, nome, valor_venda, quantidade FROM produto";
                    $resultado = $mysqli->query($sql);

                    while ($produto = $resultado->fetch_assoc()) {
                        $imagem = isset($imagens[$produto['id']]) ? $imagens[$produto['id']] : 'sem-imagem.png';
                        $quantidadeEstoque = $produto['quantidade'];
                    ?>
                        <div class="col-md-4">
                            <div class="card">
                                <img class="card-img-top" src="assets/<?php echo $imagem; ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>">
                                <div class="card-body text-center">
                                    <h5 class="card-title"><?php echo htmlspecialchars($produto['nome']); ?></h5>
                                    <p class="card-text">R$<?php echo number_format($produto['valor_venda'], 2, ',', '.'); ?></p>
                                    <p <?php echo ($quantidadeEstoque == 0) ? 'style="color: red; font-weight: bold;"' : ''; ?>>
                                        <?php echo ($quantidadeEstoque == 0) ? 'Produto esgotado!' : "Em estoque: $quantidadeEstoque"; ?>
                                    </p>
                                    <?php if ($quantidadeEstoque > 0) { ?>
                                        <a href="carrinho.php?id=<?php echo $produto['id']; ?>&preco=<?php echo urlencode($produto['valor_venda']); ?>&imagem=<?php echo urlencode("assets/$imagem"); ?>&nome=<?php echo urlencode($produto['nome']); ?>" class="btn btn-primary">Adicionar ao Carrinho</a>
                                    <?php } else { ?>
                                        <div style="height: 38px;"></div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
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
