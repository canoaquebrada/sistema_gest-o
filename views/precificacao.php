<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}
include '../includes/header.php';
?>

<h1>Precificação de Mercadorias</h1>
<form method="POST">
    <div class="form-group">
        <label>Preço de Compra</label>
        <input type="number" step="0.01" name="preco_compra" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Margem de Lucro (%)</label>
        <input type="number" step="0.01" name="margem_lucro" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Calcular Preço de Venda</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $precoCompra = $_POST['preco_compra'];
    $margemLucro = $_POST['margem_lucro'] / 100;

    $precoVenda = $precoCompra + ($precoCompra * $margemLucro);
    echo "<p class='alert alert-info'>Preço de Venda: R$ $precoVenda</p>";
}
?>

<a href="../index.php" class="btn btn-secondary">Voltar</a>

<?php include '../includes/footer.php'; ?>
