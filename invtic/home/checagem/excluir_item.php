<?php
include '../../conexao.php'; // Inclui a conexão

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);

    // Verifica se o ID é válido
    if ($id > 0) {
        $sql_delete = "DELETE FROM inventario WHERE id = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("i", $id);

        if ($stmt_delete->execute()) {
            header("Location: inventario.php?setor=" . urlencode($_GET['setor']));
            exit;
        } else {
            echo "Erro ao excluir o item.";
        }
    }
} else {
    echo "Método inválido.";
}
?>
