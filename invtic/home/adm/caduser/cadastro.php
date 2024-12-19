<?php
// Iniciar a sessão
session_start();

// Conectar ao banco de dados
include('../../../conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Verificar se as senhas coincidem
    if ($password != $confirm_password) {
        header("Location: cadastro.html?error=password_mismatch");
        exit();
    }

    // Verificar se o nome de usuário já existe
    $sql = $conn->prepare("SELECT * FROM usuarios WHERE username = ?");
    $sql->bind_param('s', $username);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        // Usuário já existe
        header("Location: cadastro.html?error=user_exists");
        exit();
    }

    // Inserir o novo usuário no banco de dados sem hash
    $sql = $conn->prepare("INSERT INTO usuarios (username, password) VALUES (?, ?)");
    $sql->bind_param('ss', $username, $password);

    if ($sql->execute()) {
        // Cadastro bem-sucedido
        header("Location: cadastro.html?success=1");
        exit();
    } else {
        echo "Erro ao cadastrar o usuário.";
    }
}
?>
