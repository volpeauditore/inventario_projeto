<?php
// Incluir o arquivo de conexão
include('../../conexao.php');

// Receber os parâmetros via POST
$localizacao_pai = $_POST['localizacao_pai'];
$localizacao_filho = $_POST['localizacao_filho'];

// Prepara a consulta SQL para obter setores
$sql = "SELECT id, nome FROM setor WHERE localizacao_pai = ? AND localizacao_filho = ?";
$stmt = $conn->prepare($sql);

// Verifica se a preparação da consulta falhou
if (!$stmt) {
    die("Erro na preparação da consulta: " . $conn->error);
}

// Vincula os parâmetros e executa a consulta
$stmt->bind_param("ss", $localizacao_pai, $localizacao_filho);
$stmt->execute();
$result = $stmt->get_result();

// Verifica se a execução da consulta falhou
if (!$result) {
    die("Erro na execução da consulta: " . $stmt->error);
}

// Gera o HTML para os setores como links estilizados
echo "<div style='display: flex; flex-wrap: wrap; gap: 10px;'>"; // Div para agrupar os botões
while ($row = $result->fetch_assoc()) {
    echo "<a href='inventario/inventario.php?setor=" . urlencode($row["nome"]) . "' style='padding: 10px; border-radius: 5px; background-color: #007BFF; color: white; text-decoration: none; display: inline-block;'>";
    echo htmlspecialchars($row["nome"]);
    echo "</a>";
}
echo "</div>"; // Fecha a div

// Fecha a conexão com o banco de dados
$stmt->close();
$conn->close();
?>
