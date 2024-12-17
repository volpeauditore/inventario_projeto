<?php
include('../../conexao.php');

// Verificar a conexão com o banco de dados
if (!$conn) {
    die('Erro na conexão: ' . mysqli_connect_error());
}

// Verificar se o parâmetro 'nome' foi passado pela URL
if (isset($_GET['nome'])) {
    $nome_setor = mysqli_real_escape_string($conn, $_GET['nome']);

    // Excluir o setor do banco de dados
    $consulta = "DELETE FROM setor WHERE nome = '$nome_setor'";
    if (mysqli_query($conn, $consulta)) {
        // Redirecionar de volta para a página principal com uma mensagem de sucesso
        header('Location: index.php?mensagem=Setor excluído com sucesso!');
        exit;
    } else {
        // Se houver erro na exclusão
        echo 'Erro ao excluir o setor: ' . mysqli_error($conn);
    }
} else {
    echo 'Nome do setor não fornecido.';
}
?>
