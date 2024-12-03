<?php
include '../../conexao.php'; // Conexão com o banco de dados

$id = $_POST['id'];
$setor = $_POST['setor'];

// Preparar e executar a exclusão do item
$sql = "DELETE FROM inventario WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<script>alert('Item excluído com sucesso!'); window.history.back ();</script>";
} else {
    echo "<script>alert('Erro ao excluir o item.'); window.history.back ();</script>";
}

$stmt->close();
$conn->close();
?>
