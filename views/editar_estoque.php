<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}
require '../includes/db.php';
include '../includes/header.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM estoque WHERE id = ? AND user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id, $_SESSION['user_id']]);
    $produto = $stmt->fetch();

    if (!$produto) {
        echo "<div class='alert alert-danger'>Produto não encontrado.</div>";
        include '../includes/footer.php';
        exit;
    }
} else {
    echo "<div class='alert alert-danger'>ID de produto não fornecido.</div>";
    include '../includes/footer.php';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $produto_nome = $_POST['produto'];
    $quantidade = $_POST['quantidade'];

    if (empty($produto_nome) || empty($quantidade) || $quantidade <= 0) {
        echo "<div class='alert alert-danger'>Por favor, preencha todos os campos corretamente.</div>";
    } else {
        $sql = "UPDATE estoque SET produto = ?, quantidade = ? WHERE id = ? AND user_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$produto_nome, $quantidade, $id, $_SESSION['user_id']]);
        echo "<div class='alert alert-success'>Produto atualizado com sucesso.</div>";
    }
}
?>

<h1>Editar Produto no Estoque</h1>
<form method="POST">
    <div class="form-group">
        <label>Produto</label>
        <input type="text" name="produto" class="form-control" value="<?php echo htmlspecialchars($produto['produto']); ?>" required>
    </div>
    <div class="form-group">
        <label>Quantidade</label>
        <input type="number" name="quantidade" class="form-control" value="<?php echo $produto['quantidade']; ?>" required min="1">
    </div>
    <button type="submit" class="btn btn-primary">Atualizar Produto</button>
</form>
<a href="estoque.php" class="btn btn-secondary mt-2">Voltar</a>

<?php include '../includes/footer.php'; ?>
