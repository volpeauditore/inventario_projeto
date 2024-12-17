<?php 
// Conectar ao banco de dados
$host = '10.1.10.100';
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
$sql = "SELECT marca FROM dispositivos WHERE categoria = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $tipoEquipamento);
$stmt->execute();
$result = $stmt->get_result();

// Obtém as marcas e retorna em formato JSON
$marcas = array();
while ($row = $result->fetch_assoc()) {
    $marcas[] = $row['marca'];
}

echo json_encode($marcas);

$stmt->close();
$conn->close();
?>
