<?php
// Configuração do banco de dados
$host = 'localhost';
$dbname = 'projeto';
$username = 'root'; // Usuário do banco
$password = '';     // Senha do banco

// Inicializando mensagens
$error_message = "";
$success_message = "";

try {
    // Conectar ao banco de dados
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificando se os dados foram enviados via POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Pegando os dados do formulário
        $nome = trim($_POST['usuario']);
        $senha = trim($_POST['senha']);

        // Verificando se os campos estão vazios
        if (empty($nome) || empty($senha)) {
            $error_message = "Todos os campos são obrigatórios!";
        } else {
            // Verificar se o usuário existe antes de atualizar a senha
            $sql_check = "SELECT id FROM usuarios WHERE usuario = :usuario";
            $stmt_check = $conn->prepare($sql_check);
            $stmt_check->bindParam(':usuario', $nome);
            $stmt_check->execute();

            if ($stmt_check->rowCount() > 0) {
                // Atualizar a senha sem criptografia
                $sql_update = "UPDATE usuarios SET senha = :senha WHERE usuario = :usuario";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bindParam(':usuario', $nome);
                $stmt_update->bindParam(':senha', $senha);
                $stmt_update->execute();

                $success_message = "Senha alterada com sucesso!";
            } else {
                $error_message = "Usuário não encontrado!";
            }
        }
    }
} catch (PDOException $e) {
    $error_message = "Erro ao conectar ao banco de dados: " . $e->getMessage();
}
?>

<!doctype html>
<html lang="pt-br">
<head>
    <title>Redefinir Senha</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-image: linear-gradient(45deg, black, #121212);
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
        input[type="text"], input[type="password"] {
            padding: 16px;
            border: none;
            outline: none;
            font-size: 18px;
            border-radius: 20px;
            width: 270px;
        }
        button {
            background-color: #64ffda;
            border: none;
            padding: 16px;
            width: 300px;
            border-radius: 12px;
            color: black;
            font-size: 20px;
            margin-top: 10px;
            cursor: pointer;
            display: grid;
            transition: 0.3s;
            font-weight: bold;
        }
        button:hover {
            background-color: #52e0c4;
            color:white;
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
</head>
<body>
    <div class="tela-cadastro">
        <h1>Redefinir Senha</h1>

        <!-- Exibir mensagens -->
        <?php if ($error_message): ?>
            <p class="mensagem"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <?php if ($success_message): ?>
            <p class="sucesso"><?php echo $success_message; ?></p>
            <meta http-equiv="refresh" content="3;url=index.php"> <!-- Redireciona após 3 segundos -->
        <?php endif; ?>

        <form action="" method="POST">
            <br>
            <input type="text" name="usuario" placeholder="Informe seu Usuário" value="<?php echo htmlspecialchars($nome ?? ''); ?>">
            <br><br>      
            <input type="password" name="senha" placeholder="Crie uma nova senha">
            <br><br>
            <button type="submit">Mudar Senha</button>
        </form>
    </div>
</body>
</html>