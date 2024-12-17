<?php
include('../../conexao.php');

// Verificar a conexão com o banco de dados
if (!$conn) {
    die('Erro na conexão: ' . mysqli_connect_error());
}

// Paginação
$itens_por_pagina = 15;
$pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($pagina_atual - 1) * $itens_por_pagina;

// Pesquisa
$termo_pesquisa = isset($_GET['pesquisa']) ? mysqli_real_escape_string($conn, $_GET['pesquisa']) : '';
$filtro = $termo_pesquisa ? "WHERE nome LIKE '%$termo_pesquisa%'" : '';

// Consulta setores
$consulta = "SELECT nome, localizacao_pai, localizacao_filho, numero_porta FROM setor $filtro LIMIT $inicio, $itens_por_pagina";
$resultado = mysqli_query($conn, $consulta);

// Verificar se a consulta de setores foi bem-sucedida
if (!$resultado) {
    die('Erro na consulta de setores: ' . mysqli_error($conn));
}

// Contagem total
$consulta_total = mysqli_query($conn, "SELECT COUNT(*) AS total FROM setor $filtro");
if (!$consulta_total) {
    die('Erro na consulta de contagem: ' . mysqli_error($conn));
}

$contagem_total = mysqli_fetch_assoc($consulta_total)['total'];
$total_paginas = ceil($contagem_total / $itens_por_pagina);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setores Cadastrados</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>

<header>
        <nav>
            <img src="../../assets/logo/logo.png" alt="logo" class="logo">
            <h1>Sistema WEB de Inventário de TIC</h1>
            <ul>
                <li><a href="cadsetor/">Cadastrar setor</a></li>
                <li><a href="../">Sair</a></li>
            </ul>
        </nav>
    </header>

<main>
    <div class="options-container">
        <form method="GET">
            <input type="text" name="pesquisa" placeholder="Buscar setor..." value="<?php echo htmlspecialchars($termo_pesquisa); ?>">
            <button type="submit">Pesquisar</button>
        </form>

        <div class="hub-container">
            <table border="1">
                <thead>
                    <tr>
                        <th>Nome do Setor</th>
                        <th>Localização Pai</th>
                        <th>Localização Filho</th>
                        <th>Número da Porta</th>
                        <th>Editar</th>
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($linha = mysqli_fetch_assoc($resultado)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($linha['nome']); ?></td>
                            <td><?php echo htmlspecialchars($linha['localizacao_pai']); ?></td>
                            <td><?php echo htmlspecialchars($linha['localizacao_filho']); ?></td>
                            <td><?php echo htmlspecialchars($linha['numero_porta']); ?></td>
                            <td><a href="editarsetor/editar.php?nome=<?php echo urlencode($linha['nome']); ?>">Editar</a></td>
                            <td><a href="#" onclick="confirmarExclusao('<?php echo urlencode($linha['nome']); ?>')">Excluir</a></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <br>

            <div class="paginacao">
                <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                    <a href="?pagina=<?php echo $i; ?>&pesquisa=<?php echo urlencode($termo_pesquisa); ?>" class="<?php echo $i == $pagina_atual ? 'ativo' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</main>

<script>
function confirmarExclusao(nome) {
    if (confirm("Confirmar exclusão do setor " + nome + "?")) {
        window.location.href = "excluir.php?nome=" + encodeURIComponent(nome);
    }
}
</script>

<footer class="footer">
    <div class="footer-content">
        <p>&copy; 2024 Inventário de ativos de TIC. Todos os direitos reservados.</p>
        <p>Desenvolvido por Alberto Nascimento - Engenheiro de computação e desenvolvedor de softwares WEB</p>
    </div>
</footer>
</body>
</html>
