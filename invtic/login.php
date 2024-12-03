<?php
// Iniciar a sessão
session_start();

// Conectar ao banco de dados
include('conexao.php');

$message = ""; // Variável para armazenar mensagens

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consulta SQL para verificar usuário e senha
    $sql = $conn->prepare("SELECT * FROM usuarios WHERE username = ? AND password = ?");
    $sql->bind_param('ss', $username, $password);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        // Login bem-sucedido
        $_SESSION['loggedin'] = true; // Define a variável de sessão como true
        $_SESSION['username'] = $username; // Armazena o nome de usuário na sessão
        $message = "Login bem-sucedido! Você será redirecionado.";
        
        // Redirecionar para a página principal
        header("Location: home/index.php");
        exit();
    } else {
        // Login falhou
        $message = "Usuário ou senha incorretos. Tente novamente.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventário de TIC - Login</title>
    <link rel="icon" href="/home/assets/login.png" type="image/png">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-container">
        <h2>Seja Bem-vindo à plataforma de gestão de inventário de TIC</h2>
        <?php if (!empty($message)) : ?>
            <div class="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="username">Nome de Usuário:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Entrar">
        </form>
    </div>
</body>
</html>
