<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Setor</title>
</head>
<body>
    <h1>Detalhes do Setor</h1>
    <?php
    // Conectar ao banco de dados
    $host = 'localhost';
    $dbname = 'inventario_icom';
    $username = 'suporte';
    $password = 'p@$$.cmicom2871';
    $conn = new mysqli($host, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Obter o ID do setor via GET
    $id = $_GET['id'];

    // Obter detalhes do setor
    $sql = "SELECT * FROM setor WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        echo "<p><strong>Nome:</strong> " . htmlspecialchars($row['nome']) . "</p>";
        echo "<p><strong>Responsável:</strong> " . htmlspecialchars($row['nome_responsavel']) . "</p>";
        echo "<p><strong>Ramal:</strong> " . htmlspecialchars($row['ramal_setor']) . "</p>";
        echo "<p><strong>Localização Pai:</strong> " . htmlspecialchars($row['localizacao_pai']) . "</p>";
        echo "<p><strong>Localização Filho:</strong> " . htmlspecialchars($row['localizacao_filho']) . "</p>";
    } else {
        echo "<p>Setor não encontrado.</p>";
    }

    $stmt->close();
    $conn->close();
    ?>
    <a href="index.php">Voltar</a>
</body>
</html>
