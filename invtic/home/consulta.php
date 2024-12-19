<?php
header('Content-Type: application/json');

// Conectar ao banco de dados
include('conexao.php');

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Consulta SQL para obter dados
$sql = "SELECT tipo_equipamento, COUNT(*) as quantidade FROM inventario GROUP BY tipo_equipamento";
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);

$conn->close();
?>
