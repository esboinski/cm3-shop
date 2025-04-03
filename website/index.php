<?php
session_start();
include('conexao.php');
$mensagem = '';

if (isset($_POST['usuario']) && isset($_POST['senha'])) {
    if (strlen($_POST['usuario']) == 0) {
        $mensagem = "<p style='color:red;'>Usuário não informado</p>";
    } else if (strlen($_POST['senha']) == 0) {
        $mensagem = "<p style='color:red;'>Preencha sua senha</p>";
    } else {
        $usuario = $mysqli->real_escape_string($_POST['usuario']);
        $senha = $mysqli->real_escape_string($_POST['senha']);

        $sql_code = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND senha = '$senha'";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
        $quantidade = $sql_query->num_rows;

        if ($quantidade == 1) {
            $usuario = $sql_query->fetch_assoc();
            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['usuario'];
            header("Location: painel.php");
            exit();
        } else {
            $mensagem = "<p style='color:red;'>Falha ao logar! Usuário ou senha incorretos</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
   
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-image: linear-gradient(45deg, black, #121212);
        }
        .tela-login {
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
            outline: none;
            padding: 16px;
            width: 300px;
            border-radius: 12px;
            color: black;
            font-size: 20px;
            margin-top: 10px;
            cursor: pointer;
            display:grid;
            font-weight: bold;
            transition: 0.3s;
        }
        button:hover {
            background-color: #52e0c4;
            color:white;
        }
        p {
            text-align: center;
        }
        a {
            color: lightblue;
        }
        .mensagem {
            text-align: center;
            font-size: 16px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="tela-login">
        <h1>Login</h1>
        <form action="" method="POST">
            <br>
            <input type="text" name="usuario" placeholder="Usuário">
            <br><br>      
            <input type="password" name="senha" placeholder="Senha">
            <br><br>
            <input type="checkbox" name="lembrar"> Lembrar Senha
            <br><br>  
            <button type="submit">Entrar</button>
            <button type="button" onclick="window.location.href='cadastrar.php'">Cadastrar-se</button>
            <p><a href="esquecisenha.php">Esqueci minha Senha</a></p>

            <!-- Exibir mensagem de erro -->
            <?php if (!empty($mensagem)) { ?>
                <div class="mensagem"><?php echo $mensagem; ?></div>
            <?php } ?>
        </form>
    </div>
</body>
</html>