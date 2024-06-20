<?php
session_start();
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['user_id'] = $usuario['id'];
        header('Location: index.php');
    } else {
        echo "Email ou senha inválidos.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form method="POST">
        Email: <input type="email" name="email" required><br>
        Senha: <input type="password" name="senha" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
