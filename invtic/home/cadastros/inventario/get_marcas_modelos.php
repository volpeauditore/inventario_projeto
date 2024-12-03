<?php 
// Configurações de conexão com o banco de dados
$servername = "localhost";
$dbname = 'inventario_icom';
$username = 'suporte';
$password = 'p@$$.cmicom2871';

// Conecta ao banco de dados
$conn = new mysqli($host, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Recebe o tipo de equipamento
$tipoEquipamento = $_POST['tipo_equipamento'];
$setor = $_POST['setor'];

// Consulta SQL para obter marcas e modelos
$sql = "SELECT DISTINCT marca, modelo FROM dispositivos WHERE categoria = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $tipoEquipamento);
$stmt->execute();
$result = $stmt->get_result();

// Arrays para armazenar marcas e modelos
$marcas = array();
$modelos = array();

while ($row = $result->fetch_assoc()) {
    if (!in_array($row['marca'], $marcas)) {
        $marcas[] = $row['marca'];
    }
    if (!in_array($row['modelo'], $modelos)) {
        $modelos[] = $row['modelo'];
    }
}

// Cria um array de resposta
$response = array(
    'marcas' => $marcas,
    'modelos' => $modelos
);

// Retorna a resposta em formato JSON
echo json_encode($response);

// Fecha a conexão
$stmt->close();
$conn->close();
?>
