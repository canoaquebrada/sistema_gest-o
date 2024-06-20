<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}
require '../includes/db.php';
include '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];

    $sql = "INSERT INTO receitas (descricao, valor, user_id) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$descricao, $valor, $_SESSION['user_id']]);

    echo "Receita adicionada com sucesso.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Adicionar Receita</title>
</head>
<body>
    <h1>Adicionar Receita</h1>
    <form method="POST">
        Descrição: <input type="text" name="descricao" required><br>
        Valor: <input type="number" step="0.01" name="valor" required><br>
        <button type="submit">Adicionar Receita</button>
    </form>
    <a href="../index.php">Voltar</a>
</body>
</html>
