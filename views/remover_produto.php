<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}
require '../includes/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM estoque WHERE id = ? AND user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id, $_SESSION['user_id']]);
    header('Location: estoque.php');
    exit;
} else {
    header('Location: estoque.php');
    exit;
}
?>
