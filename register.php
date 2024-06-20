<?php
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $email, $senha]);

    header('Location: login.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrar</title>
</head>
<body>
    <h1>Registrar</h1>
    <form method="POST">
        Nome: <input type="text" name="nome" required><br>
        Email: <input type="email" name="email" required><br>
        Senha: <input type="password" name="senha" required><br>
        <button type="submit">Registrar</button>
    </form>
</body>
</html>
