<?php
include('../../../conexao.php');

// Verificar a conexão com o banco de dados
if (!$conn) {
    die('Erro na conexão: ' . mysqli_connect_error());
}

// Obtém os dados do formulário
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$categoria = $_POST['categoria'];

// Prepara a consulta SQL para inserir os dados
$sql = "INSERT INTO dispositivos (marca, modelo, categoria) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

// Certifique-se de que o tipo de dados corresponde às suas variáveis
// 's' para strings e 'i' para inteiros
$stmt->bind_param("sss", $marca, $modelo, $categoria );

// Executa a consulta e verifica se foi bem-sucedida
if ($stmt->execute()) {
    echo "Item adicionado com sucesso!";
} else {
    echo "Erro: " . $stmt->error;
}

// Fecha a conexão com o banco de dados
$stmt->close();
$conn->close();
?>
