<?php
include('../../conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo_relatorio = $_POST['tipo_relatorio'];

    switch ($tipo_relatorio) {
        case 'resumo_tipo':
            $consulta = "SELECT tipo_equipamento, COUNT(*) AS quantidade FROM inventario GROUP BY tipo_equipamento";
            $titulo = "Resumo de Equipamentos por Tipo";
            break;

        case 'localizacao':
            $consulta = "SELECT setor, COUNT(*) AS quantidade FROM inventario GROUP BY setor";
            $titulo = "Equipamentos por Localização (Setores)";
            break;

        case 'recentes':
            $consulta = "SELECT tipo_equipamento, marca, modelo, setor, data_inventario, patrimonio FROM inventario ORDER BY data_inventario DESC LIMIT 10";
            $titulo = "Equipamentos Cadastrados Recentemente";
            break;

        case 'status':
            $consulta = "SELECT tipo_equipamento, COUNT(*) AS quantidade FROM inventario GROUP BY tipo_equipamento";
            $titulo = "Equipamentos por Status";
            break;

        case 'fabricante_modelo':
            $consulta = "SELECT tipo_equipamento, marca, modelo, COUNT(*) AS quantidade FROM inventario GROUP BY marca, modelo";
            $titulo = "Detalhamento de Equipamentos por Fabricante/Modelo";
            break;

        case 'itens_setor':
            $consulta = "SELECT s.nome AS nome_setor, COUNT(i.tipo_equipamento) AS quantidade_itens FROM setor s LEFT JOIN inventario i ON s.nome = i.setor GROUP BY s.nome ORDER BY quantidade_itens DESC";
            $titulo = "Setores com e sem Itens Inventariados";
            break;

            case 'itens_por_localizacao':
                $tipo_item = $_POST['filtro_tipo_equipamento'] ?? ''; 
                $filtro = $tipo_item ? "WHERE tipo_equipamento = '".mysqli_real_escape_string($conn, $tipo_item)."'" : '';
                $consulta = "SELECT setor, tipo_equipamento, COUNT(*) AS quantidade 
                             FROM inventario 
                             $filtro 
                             GROUP BY setor, tipo_equipamento 
                             ORDER BY setor, quantidade DESC";
                $titulo = "Quantidade de Itens por Localização";
                break;
            

        default:
            die("Tipo de relatório inválido.");
    }

    $resultado = mysqli_query($conn, $consulta);
    if (!$resultado) {
        die("Erro ao executar a consulta: " . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
        <div class="header-container">
                <img src="assets/logo.jpg" alt="Ícone" class="header-icon"> 
                <div class="header-info">
                    <p><strong>Instituto Couto Maia</strong></p>
                    <p><strong>Setor de tecnologia de comunicações</strong></p>
                    <p><strong>Relatórios de Itens Inventariados</strong></p>
                </div>
        </div>
    </header>

    <div class="filter-container">

            <button type="button" onclick="window.print()" style="padding: 10px; background-color: #007BFF; color: white; border: none; border-radius: 5px; cursor: pointer;">Imprimir relatório atual</button>

            <a href="export.php" target="_blank" style="text-decoration: none;">
                <button style="padding: 10px; background-color: #007BFF; color: white; border: none; border-radius: 5px; cursor: pointer;">
                    Exportar para CSV
                </button>
            </a>

    </div>

<table border="1">
    <thead>
        <tr>
            <?php
            if ($tipo_relatorio == 'localizacao') {
                echo "<th>Setor</th><th>Quantidade</th>";
            } elseif ($tipo_relatorio == 'resumo_tipo') {
                echo "<th>Tipo de Equipamento</th><th>Quantidade de equipamentos</th>";
            } elseif ($tipo_relatorio == 'recentes') {
                echo "<th>Tipo de Equipamento</th><th>Marca</th><th>Modelo</th><th>Setor inventáriado</th><th>Data do Inventário</th><th>Patrimonio do equipamento</th>";
            } elseif ($tipo_relatorio == 'status') {
                echo "<th>Tipo de Equipamento</th><th>Quantidade</th>";
            } elseif ($tipo_relatorio == 'fabricante_modelo') {
                echo "<th>Tipo de equipamento</th><th>Marca</th><th>Modelo</th><th>Quantidade</th>";
            } elseif ($tipo_relatorio == 'itens_setor') {
                echo "<th>Nome do Setor</th><th>Quantidade de Itens</th>";
            } elseif ($tipo_relatorio == 'itens_por_localizacao') {
                "<th>Setor</th><th>Tipo de Equipamento</th><th>Quantidade</th>";
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php while ($linha = mysqli_fetch_assoc($resultado)): ?>
            <tr>
                <?php
                foreach ($linha as $coluna) {
                    echo "<td>" . htmlspecialchars($coluna) . "</td>";
                }
                ?>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<footer>
    <p>&copy; 2024 Sistema de Inventário</p>
</footer>
</body>
</html>
