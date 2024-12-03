<?php
// Inclua o arquivo de conexão
include('../conexao.php');

// Impede qualquer saída anterior que possa atrapalhar o download
ob_clean();
ob_start();

// Consulta ao banco de dados
$sql = "SELECT setor, patrimonio, tipo_equipamento, marca, modelo, data_inventario, ultima_checagem, quantidade, observacoes FROM inventario";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Configura os cabeçalhos para o download do CSV
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="dados.csv"');

    // Abre o fluxo de saída padrão para escrever o CSV
    $output = fopen('php://output', 'w');

    // Cabeçalhos do CSV
    $header = ['Setor', 'Patrimônio', 'Tipo de Equipamento', 'Marca', 'Modelo', 'Data de Inventário', 'Última Checagem', 'Quantidade', 'Observações'];
    fputcsv($output, $header);

    // Escreve os dados no CSV
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }

    // Fecha o fluxo e encerra o script
    fclose($output);
    ob_end_flush();
    exit;
} else {
    // Exibe mensagem caso não haja dados no banco
    echo "Nenhum dado encontrado.";
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
