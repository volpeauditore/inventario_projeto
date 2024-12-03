<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="style.css"> <!-- Se tiver um CSS -->
</head>
<body>
    <h2>Cadastro de Usuário</h2>
    <form action="cadastro.php" method="POST">
        <label for="username">Nome de Usuário:</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="confirm_password">Confirme a Senha:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br>

        <input type="submit" value="Cadastrar">
    </form>
    <?php
    if (isset($_GET['error'])) {
        if ($_GET['error'] == "password_mismatch") {
            echo "<p style='color: red;'>As senhas não coincidem!</p>";
        } elseif ($_GET['error'] == "user_exists") {
            echo "<p style='color: red;'>Este nome de usuário já está em uso!</p>";
        }
    } elseif (isset($_GET['success'])) {
        echo "<p style='color: green;'>Cadastro realizado com sucesso!</p>";
    }
    ?>
</body>
</html>
