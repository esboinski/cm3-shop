<?php
session_start();
include 'conexao.php'; // Conectar ao banco de dados

// Inicializa o carrinho se não existir
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// Adicionar produto ao carrinho
if (isset($_GET['id']) && isset($_GET['preco']) && isset($_GET['imagem']) && isset($_GET['nome'])) {
    $produtoId = $_GET['id'];
    $produtoNome = $_GET['nome'];
    $produtoPreco = $_GET['preco'];
    $produtoImagem = $_GET['imagem'];

    // Buscar a quantidade disponível no banco
    $sql = "SELECT quantidade FROM produto WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $produtoId);
    $stmt->execute();
    $result = $stmt->get_result();
    $produto = $result->fetch_assoc();

    if ($produto) {
        $estoqueDisponivel = (int)$produto['quantidade'];

        $existe = false;
        foreach ($_SESSION['carrinho'] as &$produtoCarrinho) {
            if ($produtoCarrinho['id'] == $produtoId) {
                if ($produtoCarrinho['quantidade'] + 1 > $estoqueDisponivel) {
                    echo "<script>alert('Estoque insuficiente! Apenas $estoqueDisponivel unidades disponíveis.'); window.location.href='painel.php';</script>";
                    exit();
                }
                $produtoCarrinho['quantidade']++;
                $existe = true;
                break;
            }
        }
        unset($produtoCarrinho);

        if (!$existe) {
            if ($estoqueDisponivel <= 0) {
                echo "<script>alert('Produto esgotado!'); window.location.href='painel.php';</script>";
                exit();
            }
            $_SESSION['carrinho'][] = [
                'id' => $produtoId,
                'nome' => $produtoNome,
                'preco' => $produtoPreco,
                'imagem' => $produtoImagem,
                'quantidade' => 1
            ];
        }
    } else {
        echo "<script>alert('Produto não encontrado!'); window.location.href='painel.php';</script>";
    }

    header("Location: carrinho.php");
    exit();
}

// Remover item do carrinho
if (isset($_GET['remover'])) {
    $indice = $_GET['remover'];

    if (isset($_SESSION['carrinho'][$indice])) {
        $_SESSION['carrinho'][$indice]['quantidade']--;

        if ($_SESSION['carrinho'][$indice]['quantidade'] <= 0) {
            unset($_SESSION['carrinho'][$indice]);
            $_SESSION['carrinho'] = array_values($_SESSION['carrinho']);
        }
    }

    header("Location: carrinho.php");
    exit();
}
?>

<!doctype html>
<html lang="pt-br">
<head>
    <title>Carrinho</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background-color: #121212;
            color: #ffffff;
            font-family: 'Poppins', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        header {
            background-color: #1f1f1f;
            width: 100%;
            padding: 10px 0;
        }
        .container { flex: 1; padding-bottom: 50px; }
        footer {
            background-color: #1f1f1f;
            text-align: center;
            padding: 10px;
            width: 100%;
            position: relative;
            bottom: 0;
        }
        .card {
            background-color: #1f1f1f;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.4);
            transition: transform 0.3s ease;
            margin-top: 15px;
        }
        .card:hover { transform: scale(1.05); }
        .card-img-top {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            height: 250px;
            object-fit: cover;
        }
        .card-body { text-align: center; }
        .card-title {
            font-size: 18px;
            font-weight: bold;
            color: #ffffff;
        }
        .card-text {
            font-size: 16px;
            color: #64ffda;
            font-weight: bold;
        }
        .btn-primary, .btn-danger {
            border: none;
            font-weight: bold;
            transition: 0.3s;
            border-radius: 8px;
            padding: 10px 15px;
        }
        .btn-danger:hover { background-color: #ff3333; }
        .no-items {
            font-size: 18px;
            text-align: center;
            margin-top: 30px;
            color: #ffffff;
        }
        .no-items a {
            color: #64ffda;
            text-decoration: none;
            font-weight: bold;
        }
        .no-items a:hover { color: #52e0c4; }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg sticky-top">
            <div class="container">
                <img src="assets/cm3.png" class="nav-brand me-auto" style="width: 140px; height: 100;">
                <a href="painel.php" class="ms-auto btn btn-primary">
                    <i class="fa-solid fa-arrow-left"></i> Voltar às Compras
                </a>
            </div>
        </nav>
    </header>
    <div class="container">
        <h2 class="mt-5 text-center">🛒 Carrinho de Compras</h2>
        <?php if (!empty($_SESSION['carrinho'])) { ?>
            <div class="row">
                <?php foreach ($_SESSION['carrinho'] as $indice => $item) { ?>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="<?php echo $item['imagem']; ?>" class="card-img-top" alt="Produto">
                            <div class="card-body">
                                <h5 class="card-title"> <?php echo $item['nome']; ?> <span style="color: #64ffda;">(<?php echo $item['quantidade']; ?>x)</span></h5>
                                <p class="card-text">R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></p>
                                <a href="carrinho.php?id=<?php echo $item['id']; ?>&nome=<?php echo $item['nome']; ?>&preco=<?php echo $item['preco']; ?>&imagem=<?php echo $item['imagem']; ?>" class="btn btn-success">+</a>
                                <a href="carrinho.php?remover=<?php echo $indice; ?>" class="btn btn-danger">-</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <p class="no-items">Seu carrinho está vazio. <a href="painel.php">Voltar às compras</a></p>
        <?php } ?>
    </div>

    <?php if (!empty($_SESSION['carrinho'])) { ?>
        <!-- Finalizar Compra -->
        <div class="text-center mt-4">
            <a href="finalizar.php" class="btn btn-success btn-lg mb-3">Finalizar Compra</a>
        </div>
    <?php } ?>
    
    <footer>
        <p>&copy; 2025 CM3 - Todos os direitos reservados</p>
    </footer>
</body>
</html>
