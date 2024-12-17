<?php
include '../../conexao.php'; // Conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $setor = $_POST['setor'] ?? '';
    $observacoes = $_POST['observacoes'] ?? [];
    $conferido = $_POST['conferido'] ?? [];
    $excluir = $_POST['excluir'] ?? [];

    // Agrupa operações
    $erros = [];

    // Exclusão em massa
    if (!empty($excluir)) {
        $ids_para_excluir = implode(",", array_map('intval', $excluir));
        $sql_delete = "DELETE FROM inventario WHERE id IN ($ids_para_excluir)";
        
        if (!$conn->query($sql_delete)) {
            $erros[] = "Erro ao excluir itens: " . $conn->error;
        }
    }

    // Atualização em massa
    $sql_update = "UPDATE inventario SET observacoes = ?, ultima_checagem = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);

    if ($stmt_update) {
        foreach ($observacoes as $id => $obs) {
            if (!in_array($id, $excluir)) {
                $ultima_checagem = isset($conferido[$id]) ? date('Y-m-d H:i:s') : NULL;
                $stmt_update->bind_param("ssi", $obs, $ultima_checagem, $id);
                
                if (!$stmt_update->execute()) {
                    $erros[] = "Erro ao atualizar o item ID $id: " . $stmt_update->error;
                }
            }
        }
        $stmt_update->close();
    } else {
        $erros[] = "Erro na preparação da atualização: " . $conn->error;
    }

    $conn->close();

    // Exibe mensagens de erro ou redireciona
    if (!empty($erros)) {
        echo "Ocorreram os seguintes erros:<br>" . implode("<br>", $erros);
    } else {
        header("Location: index.php?setor=" . urlencode($setor));
        exit;
    }
} else {
    echo "Método inválido.";
}
?>
