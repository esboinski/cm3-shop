<?php
// Configuração do banco de dados
$host = 'localhost';
$dbname = 'projeto';
$username = 'root';
$password = '';

$error_message = "";
$success_message = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST['usuario'];
        $senha = $_POST['senha'];

        if (empty($nome) || empty($senha)) {
            $error_message = "Todos os campos são obrigatórios!";
        } else {
            $sql = "INSERT INTO usuarios (usuario, senha) VALUES (:usuario, :senha)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':usuario', $nome);
            $stmt->bindParam(':senha', $senha);
            $stmt->execute();

            $success_message = "Cadastro realizado com sucesso!<br>Redirecionando...";
        }
    }
} catch (PDOException $e) {
    $error_message = "Erro ao conectar com o banco de dados: " . $e->getMessage();
} finally {
    $conn = null;
}
?>

<!doctype html>
<html lang="pt-br">

<head>
    <title>Cadastro</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
</head>
<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
        background-image: linear-gradient(45deg, black, #0c1c33);
    }

    .tela-cadastro {
        background-color: rgba(0, 0, 0, 0.8);
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 60px;
        border-radius: 20px;
        color: whitesmoke;
        background-color: rgba(0, 0, 0, 0.4);
        box-shadow: inset 0px -4px 10px rgba(0, 0, 0, 0.3),
            inset 0px 4px 10px rgba(0, 0, 0, 0.2);
    }

    input[type="text"],
    input[type="password"] {
        padding: 16px;
        border: none;
        outline: none;
        font-size: 18px;
        border-radius: 20px;
        width: 270px;
    }

    button {
        background-color: #0c1c33;
        border: none;
        outline: none;
        padding: 16px;
        width: 300px;
        border-radius: 12px;
        color: white;
        font-size: 20px;
        margin-top: 10px;
        cursor: pointer;
    }

    button:hover {
        background-color: deepskyblue;
    }

    .mensagem {
        text-align: center;
        font-size: 16px;
        margin-top: 10px;
        color: red;
    }

    .sucesso {
        text-align: center;
        font-size: 16px;
        margin-top: 10px;
        color: green;
    }
</style>

<body>
    <main>
        <div class="tela-cadastro">
            <h1>Cadastro</h1>

            <!-- Exibição de mensagens de erro -->
            <?php if ($error_message): ?>
                <p class="mensagem"><?php echo $error_message; ?></p>
            <?php endif; ?>

            <!-- Exibição de mensagens de sucesso -->
            <?php if ($success_message): ?>
                <p class="sucesso"><?php echo $success_message; ?></p>
                <script>
                    setTimeout(function() {
                        window.location.href = 'index.php';
                    }, 3000);
                </script>
            <?php endif; ?>

            <!-- Formulário de cadastro -->
            <form action="" method="POST">
                <br>
                <input type="text" name="usuario" placeholder="Usuário"
                    value="<?php echo htmlspecialchars($nome ?? ''); ?>">
                <br><br>
                <input type="password" name="senha" placeholder="Senha">
                <br><br>
                <button type="submit">Cadastrar</button>
            </form>
        </div>
    </main>
</body>

</html>