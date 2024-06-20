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
    $sql = "SELECT * FROM despesas WHERE id = ? AND user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id, $_SESSION['user_id']]);
    $despesa = $stmt->fetch();

    if (!$despesa) {
        echo "<div class='alert alert-danger'>Despesa não encontrada.</div>";
        include '../includes/footer.php';
        exit;
    }
} else {
    echo "<div class='alert alert-danger'>ID de despesa não fornecido.</div>";
    include '../includes/footer.php';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];

    if (empty($descricao) || empty($valor) || $valor <= 0) {
        echo "<div class='alert alert-danger'>Por favor, preencha todos os campos corretamente.</div>";
    } else {
        $sql = "UPDATE despesas SET descricao = ?, valor = ? WHERE id = ? AND user_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$descricao, $valor, $id, $_SESSION['user_id']]);
        echo "<div class='alert alert-success'>Despesa atualizada com sucesso.</div>";
    }
}
?>

<h1>Editar Despesa</h1>
<form method="POST">
    <div class="form-group">
        <label>Descrição</label>
        <input type="text" name="descricao" class="form-control" value="<?php echo htmlspecialchars($despesa['descricao']); ?>" required>
    </div>
    <div class="form-group">
        <label>Valor</label>
        <input type="number" step="0.01" name="valor" class="form-control" value="<?php echo $despesa['valor']; ?>" required min="0.01">
    </div>
    <button type="submit" class="btn btn-primary">Atualizar Despesa</button>
</form>
<a href="despesas_receitas.php" class="btn btn-secondary mt-2">Voltar</a>

<?php include '../includes/footer.php'; ?>
