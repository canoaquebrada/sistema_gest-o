<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
require 'includes/db.php';
include 'includes/header.php';

$user_id = $_SESSION['user_id'];

// Calcular total de receitas
$sql_receitas = "SELECT SUM(valor) as total_receitas FROM receitas WHERE user_id = ?";
$stmt_receitas = $pdo->prepare($sql_receitas);
$stmt_receitas->execute([$user_id]);
$total_receitas = $stmt_receitas->fetchColumn();

// Calcular total de despesas
$sql_despesas = "SELECT SUM(valor) as total_despesas FROM despesas WHERE user_id = ?";
$stmt_despesas = $pdo->prepare($sql_despesas);
$stmt_despesas->execute([$user_id]);
$total_despesas = $stmt_despesas->fetchColumn();

// Calcular saldo
$saldo = $total_receitas - $total_despesas;

// Calcular movimentação total
$movimentacao_total = $total_receitas + $total_despesas;
?>

<h1>Bem-vindo ao Sistema de Gestão</h1>

<h2>Balanço Financeiro</h2>
<ul class="list-group">
    <li class="list-group-item">Total de Receitas: R$ <?php echo number_format($total_receitas, 2, ',', '.'); ?></li>
    <li class="list-group-item">Total de Despesas: R$ <?php echo number_format($total_despesas, 2, ',', '.'); ?></li>
    <li class="list-group-item">Saldo: R$ <?php echo number_format($saldo, 2, ',', '.'); ?></li>
    <li class="list-group-item">Movimentação Total: R$ <?php echo number_format($movimentacao_total, 2, ',', '.'); ?></li>
</ul>

<?php include 'includes/footer.php'; ?>
