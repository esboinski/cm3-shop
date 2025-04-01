<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

require_once 'conexao.php'; // Aqui você importa a conexão com o banco de dados

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
                    // Loop pelos produtos para exibir no HTML
                    $produtos = [
                        ["id" => 1, "nome" => "Samsung Galaxy S23", "valor_venda" => "3500.00", "imagem" => "galaxys23.png"],
                        ["id" => 2, "nome" => "Notebook Dell Inspiron 15", "valor_venda" => "4800.00", "imagem" => "notebook.jpg"],
                        ["id" => 3, "nome" => "Televisão LG 50\" 4K", "valor_venda" => "3500.00", "imagem" => "lg50.avif"],
                        ["id" => 4, "nome" => "Fone de Ouvido JBL", "valor_venda" => "500.00", "imagem" => "jbl.webp"],
                        ["id" => 5, "nome" => "Câmera Digital Canon EOS R5", "valor_venda" => "16000.00", "imagem" => "camera.jpg"],
                        ["id" => 6, "nome" => "Smartwatch Apple Watch Series 8", "valor_venda" => "3500.00", "imagem" => "relogio.jpg"]
                    ];

                    foreach ($produtos as $produto) {
                        // Consulta para pegar a quantidade do estoque do banco de dados usando $mysqli
                        $sql = "SELECT quantidade FROM produto WHERE id = ?";
                        $stmt = $mysqli->prepare($sql);
                        $stmt->bind_param("i", $produto['id']);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $produtoEstoque = $result->fetch_assoc();
                        $quantidadeEstoque = $produtoEstoque['quantidade'] ?? 0; // Caso não encontre, assume 0
                    ?>
                        <div class="col-md-4">
                            <div class="card">
                                <img class="card-img-top" src="assets/<?php echo $produto['imagem']; ?>" alt="<?php echo $produto['nome']; ?>">
                                <div class="card-body text-center">
                                    <h5 class="card-title"><?php echo $produto['nome']; ?></h5>
                                    <p class="card-text">R$<?php echo number_format($produto['valor_venda'], 2, ',', '.'); ?></p>
                                    <p>Em estoque: <?php echo $quantidadeEstoque; ?></p> <!-- Exibindo quantidade do estoque -->
                                    <a href="carrinho.php?id=<?php echo $produto['id']; ?>&preco=<?php echo urlencode($produto['valor_venda']); ?>&imagem=<?php echo urlencode('assets/' . $produto['imagem']); ?>&nome=<?php echo urlencode($produto['nome']); ?>" class="btn btn-primary">Adicionar ao Carrinho</a>
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
