<?php

date_default_timezone_set('America/Sao_Paulo'); // Ajuste conforme necessário

// Habilita a exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conectar ao banco de dados
$host = '10.1.10.100'; // Endereço do servidor de banco de dados
$dbname = 'inventario_icom'; // Nome do banco de dados
$username = 'suporte'; // Nome de usuário do banco de dados
$password = 'p@$$.cmicom2871'; // Senha do banco de dados

// Cria uma conexão com o banco de dados
$conn = new mysqli($host, $username, $password, $dbname);

// Verifica se houve um erro na conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obtém os dados do formulário e faz a sanitização para evitar injeção de código malicioso
$tipo_equipamento = htmlspecialchars($_POST['tipo_equipamento'], ENT_QUOTES, 'UTF-8');
$setor = htmlspecialchars($_POST['setor'], ENT_QUOTES, 'UTF-8');
$marca = htmlspecialchars($_POST['marca'], ENT_QUOTES, 'UTF-8');
$modelo = htmlspecialchars($_POST['modelo'], ENT_QUOTES, 'UTF-8');
$ramal = isset($_POST['ramal']) && $_POST['ramal'] !== '' ? (int) $_POST['ramal'] : null;
$ip_ramal = htmlspecialchars($_POST['ip_ramal'], ENT_QUOTES, 'UTF-8');
$mac_ramal = htmlspecialchars($_POST['mac_ramal'], ENT_QUOTES, 'UTF-8');
$patrimonio = isset($_POST['patrimonio']) && $_POST['patrimonio'] !== '' ? (int) $_POST['patrimonio'] : null;
$quantidade = isset($_POST['quantidade']) ? (int) $_POST['quantidade'] : 0;
$observacoes = htmlspecialchars($_POST['observacoes'], ENT_QUOTES, 'UTF-8');

// Verifica se o checkbox "Não identificado" foi marcado
if (isset($_POST['n/a']) && $_POST['n/a'] === 'n/a') {
    $patrimonio = '0000';  // Se o checkbox foi marcado, define o patrimônio como '0000'
} else {
    $patrimonio = isset($_POST['patrimonio']) && $_POST['patrimonio'] !== '' ? (int) $_POST['patrimonio'] : null;
}

// Captura a data e hora atual
$data_inventario = date('Y-m-d H:i:s');

// Prepara a consulta SQL para inserir os dados
$sql = "INSERT INTO inventario (setor, data_inventario, tipo_equipamento, marca, modelo, ramal, ip_ramal, mac_ramal, patrimonio, quantidade, observacoes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// Verifica se a preparação da consulta foi bem-sucedida
if ($stmt === false) {
    die("Erro na preparação da consulta: " . $conn->error);
}

// Vincula os parâmetros
$stmt->bind_param("ssssssssiii", $setor, $data_inventario, $tipo_equipamento, $marca, $modelo, $ramal, $ip_ramal, $mac_ramal, $patrimonio, $quantidade, $observacoes);

// Executa a consulta
if ($stmt->execute()) {
    echo "<script>alert('Seu item foi cadastrado com sucesso!'); window.history.back();</script>";
} else {
    die("Erro ao executar a consulta: " . $stmt->error);
}

// Fecha a conexão com o banco de dados
$stmt->close();
$conn->close();
?>