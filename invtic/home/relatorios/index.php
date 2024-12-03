<?php
// Conectar ao banco de dados
include('../conexao.php');

// Filtros
$nomeItem = isset($_POST['nomeItem']) ? $_POST['nomeItem'] : '';
$patrimonio = isset($_POST['patrimonio']) ? $_POST['patrimonio'] : '';
$tipo_equipamento = isset($_POST['tipo_equipamento']) ? $_POST['tipo_equipamento'] : '';
$setor = isset($_POST['setor']) ? $_POST['setor'] : '';

// Consulta SQL ajustada para buscar os campos solicitados
$sql = "
    SELECT 
        patrimonio,
        tipo_equipamento,
        marca,
        modelo,
        observacoes,
        data_inventario,
        ultima_checagem,
        setor,
        quantidade
    FROM 
        inventario 
    WHERE 
        1=1";

// Adiciona os filtros dinâmicos
if ($nomeItem) {
    $sql .= " AND nome_item LIKE '%$nomeItem%'";
}
if ($patrimonio) {
    $sql .= " AND patrimonio LIKE '%$patrimonio%'";
}
if ($tipo_equipamento) {
    $sql .= " AND tipo_equipamento = '$tipo_equipamento'";
}
if ($setor) {
    $sql .= " AND setor = '$setor'";
}

$result = $conn->query($sql);

// Verifica se a consulta foi executada corretamente
if (!$result) {
    die("Erro na consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios de Itens Inventariados</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="header-container">
                <img src="assets/logo.jpg" alt="Ícone" class="header-icon"> <!-- Substitua pelo caminho correto -->
                <div class="header-info">
                    <p><strong>Instituto Couto Maia</strong></p>
                    <p><strong>Setor de tecnologia de comunicações</strong></p>
                    <p><strong>Relatórios de Itens Inventariados</strong></p>
                </div>
        </div>

        <nav>
            <a href="home/index.php">Início</a>
        </nav>
    </header>
    
    <div class="filter-container">
        <form method="POST" action="">
            <label for="nomeItem">Nome do Item:</label>
            <input type="text" id="nomeItem" name="nomeItem" value="<?php echo htmlspecialchars($nomeItem); ?>">

            <label for="setor">Localização do item:</label>
            <input type="text" id="setor" name="setor" value="<?php echo htmlspecialchars($setor); ?>">
            <input type="submit" value="Filtrar">

            <label for="tipo_equipamento">Tipo do item:</label>
            <input type="text" id="tipo_equipamento" name="tipo_equipamento" value="<?php echo htmlspecialchars($tipo_equipamento); ?>">
            <input type="submit" value="Filtrar">            

            <button type="button" onclick="window.print()">Imprimir relatório atual</button>

            <a href="export.php" target="_blank" style="text-decoration: none;">
                <button style="padding: 10px; background-color: #007BFF; color: white; border: none; border-radius: 5px; cursor: pointer;">
                    Exportar para CSV
                </button>
            </a>


        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Localização</th>
                <th>Patrimônio</th>
                <th>Tipo de Equipamento</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Data do inventário</th>
                <th>Última Checagem</th>
                <th>Quantidade</th>
                <th>Observações</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['setor']); ?></td>
                        <td><?php echo htmlspecialchars($row['patrimonio']); ?></td>
                        <td><?php echo htmlspecialchars($row['tipo_equipamento']); ?></td>
                        <td><?php echo htmlspecialchars($row['marca']); ?></td>
                        <td><?php echo htmlspecialchars($row['modelo']); ?></td>
                        <td><?php echo htmlspecialchars($row['data_inventario']); ?></td>
                        <td><?php echo htmlspecialchars($row['ultima_checagem']); ?></td>
                        <td><?php echo htmlspecialchars($row['quantidade']); ?></td>
                        <td><?php echo htmlspecialchars($row['observacoes']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">Nenhum registro encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="signature">
            <p>Assinatura: __________________________</p>
            <p>Data: <?php echo date('d/m/Y'); ?></p>
    </div>

    <footer>
        <p>© 2024 Inventário de TIC</p>
    </footer>
</body>
</html>
