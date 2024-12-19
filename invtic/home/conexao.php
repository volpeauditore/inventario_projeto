<?php
// conexao.php

$servername = "10.1.10.100";
$username = "suporte";
$password = "p@$$.cmicom2871";
$dbname = "inventario_icom";

// Criar a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
