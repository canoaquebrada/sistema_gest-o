<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}
require '../includes/db.php';
include '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $produto = $_POST['produto'];
    $quantidade = $_POST['quantidade'];
    $data = $_POST['data'];

    if (empty($produto) || empty($quantidade) || $quantidade <= 0 || empty($data)) {
        echo "<div class='alert alert-danger'>Por favor, preencha todos os campos corretamente.</div>";
    } else {
        $sql = "INSERT INTO estoque (produto, quantidade, data, user_id) VALUES (?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE quantidade = quantidade + VALUES(quantidade)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$produto, $quantidade, $data, $_SESSION['user_id']]);
        echo "<div class='alert alert-success'>Produto adicionado ao estoque com sucesso.</div>";
    }
}
?>

<h1>Adicionar Produto ao Estoque</h1>
<form method="POST">
    <div class="form-group">
        <label>Produto</label>
        <input type="text" name="produto" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Quantidade</label>
        <input type="number" name="quantidade" class="form-control" required min="1">
    </div>
    <div class="form-group">
        <label>Data</label>
        <input type="date" name="data" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Adicionar ao Estoque</button>
</form>
<a href="../index.php" class="btn btn-secondary mt-2">Voltar</a>

<?php include '../includes/footer.php'; ?>
