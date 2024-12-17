<?php
include '../../conexao.php'; // Conexão com o banco de dados

$setor = $_POST['setor'];
$observacoes = $_POST['observacoes'];
$conferido = isset($_POST['conferido']) ? $_POST['conferido'] : [];

foreach ($observacoes as $id => $obs) {
    $ultima_checagem = isset($conferido[$id]) ? date('Y-m-d H:i:s') : NULL;
    
    $sql = "UPDATE inventario SET observacoes = ?, ultima_checagem = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    // Verifica se a preparação foi bem-sucedida
    if ($stmt === false) {
        die("Erro na preparação da consulta SQL: " . $conn->error);
    }
    
    $stmt->bind_param("ssi", $obs, $ultima_checagem, $id);
    
    // Executa a consulta e verifica se foi bem-sucedida
    if (!$stmt->execute()) {
        die("Erro ao executar a atualização: " . $stmt->error);
    }
}

// Fecha a declaração e a conexão
$stmt->close();
$conn->close();

echo "<script>alert('Checagem confirmada com sucesso!'); window.history.back ();</script>";
?>
