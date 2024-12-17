<?php
include '../../conexao.php'; // Conexão com o banco de dados

$setor = isset($_GET['setor']) ? htmlspecialchars($_GET['setor']) : '';

// Consultas para cada tipo de equipamento
$sql_computador = "SELECT id, tipo_equipamento, marca, modelo, patrimonio, quantidade, observacoes FROM inventario WHERE setor = ? AND tipo_equipamento = 'computador'";
$sql_monitor = "SELECT id, tipo_equipamento, marca, modelo, patrimonio, quantidade, observacoes FROM inventario WHERE setor = ? AND tipo_equipamento = 'monitor'";
$sql_impressora = "SELECT id, tipo_equipamento, marca, modelo, patrimonio, quantidade, observacoes FROM inventario WHERE setor = ? AND tipo_equipamento = 'impressora'";
$sql_telefone = "SELECT id, tipo_equipamento, marca, modelo, ramal, ip_ramal, mac_ramal, observacoes FROM inventario WHERE setor = ? AND tipo_equipamento = 'telefone'";
$sql_outros = "SELECT id, tipo_equipamento, marca, modelo, patrimonio, quantidade, observacoes FROM inventario WHERE setor = ? AND tipo_equipamento NOT IN ('computador', 'monitor', 'impressora', 'telefone')";

// Prepara e executa as consultas
$stmt_computador = $conn->prepare($sql_computador);
$stmt_computador->bind_param("s", $setor);
$stmt_computador->execute();
$result_computador = $stmt_computador->get_result();

$stmt_monitor = $conn->prepare($sql_monitor);
$stmt_monitor->bind_param("s", $setor);
$stmt_monitor->execute();
$result_monitor = $stmt_monitor->get_result();

$stmt_impressora = $conn->prepare($sql_impressora);
$stmt_impressora->bind_param("s", $setor);
$stmt_impressora->execute();
$result_impressora = $stmt_impressora->get_result();

$stmt_telefone = $conn->prepare($sql_telefone);
$stmt_telefone->bind_param("s", $setor);
$stmt_telefone->execute();
$result_telefone = $stmt_telefone->get_result();

$stmt_outros = $conn->prepare($sql_outros);
$stmt_outros->bind_param("s", $setor);
$stmt_outros->execute();
$result_outros = $stmt_outros->get_result();

// Fechando a conexão
$stmt_computador->close();
$stmt_monitor->close();
$stmt_impressora->close();
$stmt_telefone->close();
$stmt_outros->close();
$conn->close();
?>
