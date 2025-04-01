<?php
session_start();
include('conexao.php');

// Verifica se o carrinho está vazio
if (!isset($_SESSION['carrinho']) || empty($_SESSION['carrinho'])) {
    header("Location: painel.php"); // Redireciona para o painel se o carrinho estiver vazio
    exit();
}

// Percorre os itens do carrinho e atualiza a quantidade no banco de dados
foreach ($_SESSION['carrinho'] as $item) {
    $produtoId = $item['id'];  // ID do produto
    $quantidadeComprada = $item['quantidade'];  // Quantidade comprada do produto

    // Prepara a consulta para atualizar a quantidade do produto
    $sqlUpdate = "UPDATE produto SET quantidade = quantidade - ? WHERE id = ?";
    $stmt = $mysqli->prepare($sqlUpdate);

    if ($stmt) {
        // Liga os parâmetros
        $stmt->bind_param("ii", $quantidadeComprada, $produtoId);

        // Executa a consulta
        $stmt->execute();

        // Verifica se a consulta foi executada com sucesso
        if ($stmt->affected_rows > 0) {
            // A quantidade foi atualizada com sucesso
        } else {
            // Caso o produto não tenha sido encontrado ou a quantidade não tenha sido alterada
            echo "<script>alert('Erro ao atualizar a quantidade do produto (ID: $produtoId).');</script>";
        }

        // Fecha a declaração
        $stmt->close();
    } else {
        // Se não conseguir preparar a consulta
        echo "<script>alert('Erro na preparação da consulta SQL.');</script>";
    }
}

// Limpa o carrinho após a compra
unset($_SESSION['carrinho']);

// Exibe mensagem de sucesso e redireciona de volta para o painel
echo "<script>alert('Compra finalizada com sucesso!'); window.location.href='painel.php';</script>";
?>
