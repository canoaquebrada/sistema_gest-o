<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}
require '../includes/db.php';
include '../includes/header.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT id, produto, quantidade FROM estoque WHERE user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$produtos = $stmt->fetchAll();

function exibirEstoque($produtos) {
    foreach ($produtos as $produto) {
        echo "<li class='list-group-item d-flex justify-content-between align-items-center'>
                Produto: {$produto['produto']}, Quantidade: {$produto['quantidade']}
                <span>
                    <a href='editar_estoque.php?id={$produto['id']}' class='btn btn-sm btn-warning'>Editar</a>
                    <a href='remover_produto.php?id={$produto['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Tem certeza que deseja remover este produto?\");'>Remover</a>
                </span>
              </li>";
    }
}
?>

<h1>Controle de Estoque</h1>
<ul class="list-group">
    <?php exibirEstoque($produtos); ?>
</ul>
<a href="../index.php" class="btn btn-secondary">Voltar</a>
<a href="adicionar_estoque.php" class="btn btn-primary mt-2">Adicionar Produto</a>

<?php include '../includes/footer.php'; ?>
