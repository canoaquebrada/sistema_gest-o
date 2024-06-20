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

    $sql = "INSERT INTO despesas (descricao, valor, user_id) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$descricao, $valor, $_SESSION['user_id']]);

    echo "Despesa adicionada com sucesso.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Adicionar Despesa</title>
</head>
<body>
    <h1>Adicionar Despesa</h1>
    <form method="POST">
    <div class="form-group">
        Descrição: <input type="text" name="descricao" class="form-control" required><br>
    </div>
    <div class="form-group">
        Valor: <input type="number" step="0.01" name="valor" class="form-control" required><br>
    </div>
        <button type="submit" class="success">Adicionar Despesa</button>
    </form>
    <a href="../index.php">Voltar</a>
</body>
</html>
