<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}
require '../includes/db.php';
include '../includes/header.php';

$user_id = $_SESSION['user_id'];

$sql_despesas = "SELECT id, descricao, valor FROM despesas WHERE user_id = ?";
$stmt_despesas = $pdo->prepare($sql_despesas);
$stmt_despesas->execute([$user_id]);
$despesas = $stmt_despesas->fetchAll();

$sql_receitas = "SELECT id, descricao, valor FROM receitas WHERE user_id = ?";
$stmt_receitas = $pdo->prepare($sql_receitas);
$stmt_receitas->execute([$user_id]);
$receitas = $stmt_receitas->fetchAll();

function calcularSaldo($despesas, $receitas) {
    $totalDespesas = array_sum(array_column($despesas, 'valor'));
    $totalReceitas = array_sum(array_column($receitas, 'valor'));
    return $totalReceitas - $totalDespesas;
}

$saldo = calcularSaldo($despesas, $receitas);
?>

<h1>Controle de Despesas e Receitas</h1>
<h2>Despesas</h2>
<ul class="list-group">
    <?php foreach ($despesas as $despesa): ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <?php echo $despesa['descricao']; ?>: R$ <?php echo $despesa['valor']; ?>
            <span>
                <a href="editar_despesa.php?id=<?php echo $despesa['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
            </span>
        </li>
    <?php endforeach; ?>
</ul>

<h2>Receitas</h2>
<ul class="list-group">
    <?php foreach ($receitas as $receita): ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <?php echo $receita['descricao']; ?>: R$ <?php echo $receita['valor']; ?>
            <span>
                <a href="editar_receita.php?id=<?php echo $receita['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
            </span>
        </li>
    <?php endforeach; ?>
</ul>

<h2>Saldo</h2>
<div class="alert alert-info">R$ <?php echo $saldo; ?></div>

<a href="../index.php" class="btn btn-secondary">Voltar</a>

<?php include '../includes/footer.php'; ?>
