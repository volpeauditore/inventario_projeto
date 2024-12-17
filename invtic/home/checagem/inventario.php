<?php
include '../../conexao.php'; // Conexão com o banco de dados

$setor = isset($_GET['setor']) ? htmlspecialchars($_GET['setor']) : '';

// Consultas para cada tipo de equipamento
$sql_computador = "SELECT id, tipo_equipamento, marca, modelo, patrimonio, quantidade, observacoes FROM inventario WHERE setor = ? AND tipo_equipamento = 'computador'";
$sql_monitor = "SELECT id, tipo_equipamento, marca, modelo, patrimonio, quantidade, observacoes FROM inventario WHERE setor = ? AND tipo_equipamento = 'monitor'";
$sql_impressora = "SELECT id, tipo_equipamento, marca, modelo, patrimonio, quantidade, observacoes FROM inventario WHERE setor = ? AND tipo_equipamento = 'impressora'";
$sql_telefone = "SELECT id, tipo_equipamento, marca, modelo, ramal, ip_ramal, mac_ramal, observacoes FROM inventario WHERE setor = ? AND tipo_equipamento = 'telefone'";
$sql_outros = "SELECT id, tipo_equipamento, marca, modelo, patrimonio, quantidade, observacoes FROM inventario WHERE setor = ? AND tipo_equipamento NOT IN ('computador', 'monitor', 'impressora', 'telefone')";

// Prepara e executa as consultas
$stmt_computador = $conn->prepare($sql_computador);
$stmt_computador->bind_param("s", $setor);
$stmt_computador->execute();
$result_computador = $stmt_computador->get_result();

$stmt_monitor = $conn->prepare($sql_monitor);
$stmt_monitor->bind_param("s", $setor);
$stmt_monitor->execute();
$result_monitor = $stmt_monitor->get_result();

$stmt_impressora = $conn->prepare($sql_impressora);
$stmt_impressora->bind_param("s", $setor);
$stmt_impressora->execute();
$result_impressora = $stmt_impressora->get_result();

$stmt_telefone = $conn->prepare($sql_telefone);
$stmt_telefone->bind_param("s", $setor);
$stmt_telefone->execute();
$result_telefone = $stmt_telefone->get_result();

$stmt_outros = $conn->prepare($sql_outros);
$stmt_outros->bind_param("s", $setor);
$stmt_outros->execute();
$result_outros = $stmt_outros->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checagem de Inventário</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>

<header>
    <nav>
        <img src="assets/logo/logo.png" alt="logo" class="logo">
        <h1>Checagem de Inventário</h1>
        <ul>
            <li><a href="../home.php">Voltar</a></li>
        </ul>
    </nav>
</header>

<div class="opcoes">
    <h2>Checar itens do setor: <?php echo $setor; ?></h2>

    <form action="processar_checagem.php" method="post">
        <input type="hidden" name="setor" value="<?php echo $setor; ?>">

        <h3>Computadores</h3>
        <table class="tabela-itens">
            <thead>
                <tr>
                    <th>Tipo de Equipamento</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Patrimônio</th>
                    <th>Quantidade</th>
                    <th>Observações</th>
                    <th>Conferido</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result_computador->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['tipo_equipamento']); ?></td>
                    <td><?php echo htmlspecialchars($row['marca']); ?></td>
                    <td><?php echo htmlspecialchars($row['modelo']); ?></td>
                    <td><?php echo htmlspecialchars($row['patrimonio']); ?></td>
                    <td><input type="number" name="quantidade[<?php echo $row['id']; ?>]" value="<?php echo htmlspecialchars($row['quantidade']); ?>"></td>
                    <td><input type="text" name="observacoes[<?php echo $row['id']; ?>]" value="<?php echo htmlspecialchars($row['observacoes']); ?>"></td>
                    <td><input type="checkbox" name="conferido[<?php echo $row['id']; ?>]"></td>
                    <td>
                        <form action="excluir_item.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="btn-excluir">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>

        <h3>Monitores</h3>
        <table class="tabela-itens">
            <thead>
                <tr>
                    <th>Tipo de Equipamento</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Patrimônio</th>
                    <th>Quantidade</th>
                    <th>Observações</th>
                    <th>Conferido</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result_monitor->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['tipo_equipamento']); ?></td>
                    <td><?php echo htmlspecialchars($row['marca']); ?></td>
                    <td><?php echo htmlspecialchars($row['modelo']); ?></td>
                    <td><?php echo htmlspecialchars($row['patrimonio']); ?></td>
                    <td><input type="number" name="quantidade[<?php echo $row['id']; ?>]" value="<?php echo htmlspecialchars($row['quantidade']); ?>"></td>
                    <td><input type="text" name="observacoes[<?php echo $row['id']; ?>]" value="<?php echo htmlspecialchars($row['observacoes']); ?>"></td>
                    <td><input type="checkbox" name="conferido[<?php echo $row['id']; ?>]"></td>
                    <td>
                        <form action="excluir_item.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="btn-excluir">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>

        <h3>Impressoras</h3>
        <table class="tabela-itens">
            <thead>
                <tr>
                    <th>Tipo de Equipamento</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Patrimônio</th>
                    <th>Quantidade</th>
                    <th>Observações</th>
                    <th>Conferido</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result_impressora->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['tipo_equipamento']); ?></td>
                    <td><?php echo htmlspecialchars($row['marca']); ?></td>
                    <td><?php echo htmlspecialchars($row['modelo']); ?></td>
                    <td><?php echo htmlspecialchars($row['patrimonio']); ?></td>
                    <td><input type="number" name="quantidade[<?php echo $row['id']; ?>]" value="<?php echo htmlspecialchars($row['quantidade']); ?>"></td>
                    <td><input type="text" name="observacoes[<?php echo $row['id']; ?>]" value="<?php echo htmlspecialchars($row['observacoes']); ?>"></td>
                    <td><input type="checkbox" name="conferido[<?php echo $row['id']; ?>]"></td>
                    <td>
                        <form action="excluir_item.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="btn-excluir">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>

        <h3>Telefones</h3>
        <table class="tabela-itens">
            <thead>
                <tr>
                    <th>Tipo de Equipamento</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Número deste ramal</th>
                    <th>IP deste ramal</th>
                    <th>Endereço MAC deste ramal</th>
                    <th>Observações</th>
                    <th>Conferido</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result_telefone->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['tipo_equipamento']); ?></td>
                    <td><?php echo htmlspecialchars($row['marca']); ?></td>
                    <td><?php echo htmlspecialchars($row['modelo']); ?></td>
                    <td><?php echo htmlspecialchars($row['ramal']); ?></td>
                    <td><?php echo htmlspecialchars($row['ip_ramal']); ?></td>
                    <td><input type="text" name="mac_ramal[<?php echo $row['id']; ?>]" value="<?php echo htmlspecialchars($row['mac_ramal']); ?>"></td>
                    <td><input type="text" name="observacoes[<?php echo $row['id']; ?>]" value="<?php echo htmlspecialchars($row['observacoes']); ?>"></td>
                    <td><input type="checkbox" name="conferido[<?php echo $row['id']; ?>]"></td>
                    <td>
                        <form action="excluir_item.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="btn-excluir">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>

        <h3>Outros</h3>
        <table class="tabela-itens">
            <thead>
                <tr>
                    <th>Tipo de Equipamento</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Patrimônio</th>
                    <th>Quantidade</th>
                    <th>Observações</th>
                    <th>Conferido</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result_outros->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['tipo_equipamento']); ?></td>
                    <td><?php echo htmlspecialchars($row['marca']); ?></td>
                    <td><?php echo htmlspecialchars($row['modelo']); ?></td>
                    <td><?php echo htmlspecialchars($row['patrimonio']); ?></td>
                    <td><input type="number" name="quantidade[<?php echo $row['id']; ?>]" value="<?php echo htmlspecialchars($row['quantidade']); ?>"></td>
                    <td><input type="text" name="observacoes[<?php echo $row['id']; ?>]" value="<?php echo htmlspecialchars($row['observacoes']); ?>"></td>
                    <td><input type="checkbox" name="conferido[<?php echo $row['id']; ?>]"></td>
                    <td>
                        <form action="excluir_item.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="btn-excluir">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>

        <br>

        <!-- Botão de checagem -->
        <button type="submit" class="btn-checar">Checar Inventário</button>
    </form>

    <!-- Botão de impressão -->
    <button onclick="window.print();" class="btn-imprimir">Imprimir</button>

</div>

<br>

<footer> Página em desenvolvimento </footer>

</body>
</html>

<?php
$stmt_computador->close();
$stmt_monitor->close();
$stmt_impressora->close();
$stmt_telefone->close();
$stmt_outros->close();
$conn->close();
?>
