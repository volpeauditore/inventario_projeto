<?php
// Conectar ao banco de dados
include '../../conexao.php'; // Inclui a conexão

// Verifica se houve um erro na conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Receber a localização pai via POST
$localizacao_pai = $_POST['localizacao_pai'];

// Obter sublocalizações
$sql = "SELECT DISTINCT localizacao_filho FROM setor WHERE localizacao_pai = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $localizacao_pai);
$stmt->execute();
$result = $stmt->get_result();

$options = "<option value=\"\">Selecione uma sublocalização</option>";
while ($row = $result->fetch_assoc()) {
    $options .= "<option value=\"" . htmlspecialchars($row['localizacao_filho']) . "\">" . htmlspecialchars($row['localizacao_filho']) . "</option>";
}

echo $options;

$stmt->close();
$conn->close();
?>
