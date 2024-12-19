<?php include 'processa_inventario.php'; ?>

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
        <img src="../../assets/logo/logo.png" alt="logo" class="logo">
        <h1>Checagem de Inventário</h1>
        <ul>
            <li><a href="../home.php">Voltar</a></li>
        </ul>
    </nav>
</header>

<main class="main">
    <div class="options-container">
    <h2>Checar itens do setor: <?php echo $setor; ?></h2>

        <form action="processar_checagem.php" method="post">
            <input type="hidden" name="setor" value="<?php echo $setor; ?>">

            <h3>Computadores</h3>
            <div class="table-container">
            <table class="tabela-itens">
                <thead>
                    <tr>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Patrimônio</th>
                        <th>Observações</th>
                        <th>Conferido</th>
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($row = $result_computador->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['marca']); ?></td>
                        <td><?php echo htmlspecialchars($row['modelo']); ?></td>
                        <td><?php echo htmlspecialchars($row['patrimonio']); ?></td>
                        <td><input type="text" name="observacoes[<?php echo $row['id']; ?>]" value="<?php echo htmlspecialchars($row['observacoes']); ?>"></td>
                        <td><input type="checkbox" name="conferido[<?php echo $row['id']; ?>]"></td>
                        <td><input type="checkbox" name="excluir[]" value="<?php echo $row['id']; ?>"> Excluir</td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>

            <h3>Monitores</h3>
            <table class="tabela-itens">
                <thead>
                    <tr>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Patrimônio</th>
                        <th>Observações</th>
                        <th>Conferido</th>
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($row = $result_monitor->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['marca']); ?></td>
                        <td><?php echo htmlspecialchars($row['modelo']); ?></td>
                        <td><?php echo htmlspecialchars($row['patrimonio']); ?></td>
                        <td><input type="text" name="observacoes[<?php echo $row['id']; ?>]" value="<?php echo htmlspecialchars($row['observacoes']); ?>"></td>
                        <td><input type="checkbox" name="conferido[<?php echo $row['id']; ?>]"></td>
                        <td><input type="checkbox" name="excluir[]" value="<?php echo $row['id']; ?>"> Excluir</td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>

            <h3>Impressoras</h3>
            <table class="tabela-itens">
                <thead>
                    <tr>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Patrimônio</th>
                        <th>Observações</th>
                        <th>Conferido</th>
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($row = $result_impressora->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['marca']); ?></td>
                        <td><?php echo htmlspecialchars($row['modelo']); ?></td>
                        <td><?php echo htmlspecialchars($row['patrimonio']); ?></td>
                        <td><input type="text" name="observacoes[<?php echo $row['id']; ?>]" value="<?php echo htmlspecialchars($row['observacoes']); ?>"></td>
                        <td><input type="checkbox" name="conferido[<?php echo $row['id']; ?>]"></td>
                        <td><input type="checkbox" name="excluir[]" value="<?php echo $row['id']; ?>"> Excluir</td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>

            <h3>Telefones</h3>
            <table class="tabela-itens">
                <thead>
                    <tr>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Número deste ramal</th>
                        <th>IP deste ramal</th>
                        <th>Endereço MAC deste ramal</th>
                        <th>Conferido</th>
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($row = $result_telefone->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['marca']); ?></td>
                        <td><?php echo htmlspecialchars($row['modelo']); ?></td>
                        <td><?php echo htmlspecialchars($row['ramal']); ?></td>
                        <td><?php echo htmlspecialchars($row['ip_ramal']); ?></td>
                        <td><input type="text" name="mac_ramal[<?php echo $row['id']; ?>]" value="<?php echo htmlspecialchars($row['mac_ramal']); ?>"></td>
                        <td><input type="checkbox" name="conferido[<?php echo $row['id']; ?>]"></td>
                        <td><input type="checkbox" name="excluir[]" value="<?php echo $row['id']; ?>"> Excluir</td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
                    <br>
            <h3>Outros equipamentos</h3>
            <table class="tabela-itens">
                <thead>
                    <tr>
                        <th>Tipo de Equipamento</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Patrimônio</th>
                        <th>Quantidade</th>
                        <th>Conferido</th>
                        <th>Excluir</th>
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
                        <td><input type="checkbox" name="conferido[<?php echo $row['id']; ?>]"></td>
                        <td><input type="checkbox" name="excluir[]" value="<?php echo $row['id']; ?>"> Excluir</td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        <br>

        <button type="submit">Checar Inventário</button>

        <br><br>

        </form>
        </div>
        
        <br>
        <button onclick="window.print();">Imprimir</button>

</main>

<footer> Página em desenvolvimento </footer>

</body>
</html>
