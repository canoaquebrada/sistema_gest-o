<?php
require '../includes/db.php';
include '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data_inicio = $_POST['data_inicio'];
    $data_fim = $_POST['data_fim'];

    function gerarXML($dados, $nomeArquivo) {
        $xml = new SimpleXMLElement('<Dados/>');
        foreach ($dados as $item) {
            $itemElement = $xml->addChild('Item');
            foreach ($item as $chave => $valor) {
                $itemElement->addChild($chave, htmlspecialchars($valor));
            }
        }
        $xml->asXML("$nomeArquivo.xml");
    }

    function gerarRelatorioCSV($dados, $nomeArquivo) {
        $arquivo = fopen("$nomeArquivo.csv", 'w');
        fputcsv($arquivo, array_keys($dados[0]));
        foreach ($dados as $linha) {
            fputcsv($arquivo, $linha);
        }
        fclose($arquivo);
    }

    // Consultar dados com base nas datas fornecidas
    $sql = "SELECT * FROM estoque WHERE data BETWEEN ? AND ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$data_inicio, $data_fim]);
    $dados = $stmt->fetchAll();

    gerarXML($dados, 'relatorio_estoque');
    gerarRelatorioCSV($dados, 'relatorio_estoque');
    $relatorios_gerados = true;
} else {
    $relatorios_gerados = false;
}
?>

<h1>Gerar XML e Relatórios</h1>

<?php if ($relatorios_gerados): ?>
    <p class="alert alert-success">Relatórios gerados com sucesso.</p>
    <a href="relatorio_estoque.xml" class="btn btn-primary">Baixar XML</a>
    <a href="relatorio_estoque.csv" class="btn btn-primary">Baixar CSV</a>
    <a href="../index.php" class="btn btn-secondary">Voltar</a>
<?php else: ?>
    <form method="POST">
        <div class="form-group">
            <label>Data de Início</label>
            <input type="date" name="data_inicio" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Data de Fim</label>
            <input type="date" name="data_fim" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary" onclick="return confirm('Você deseja realmente gerar os relatórios para o período selecionado?');">Gerar Relatórios</button>
    </form>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>
