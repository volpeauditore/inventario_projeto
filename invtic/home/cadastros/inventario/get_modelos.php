<?php
// Conectar ao banco de dados
$host = 'localhost';
$dbname = 'inventario_icom';
$username = 'suporte';
$password = 'p@$$.cmicom2871';
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Recebe o tipo de equipamento
$tipoEquipamento = $_POST['tipo_equipamento'];

// Prepara a consulta SQL
$sql = "SELECT modelo FROM dispositivos WHERE categoria = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $tipoEquipamento);
$stmt->execute();
$result = $stmt->get_result();

// Obtém os modelos e retorna em formato JSON
$modelos = array();
while ($row = $result->fetch_assoc()) {
    $modelos[] = $row['modelo'];
}

echo json_encode($modelos);

$stmt->close();
$conn->close();
?>
