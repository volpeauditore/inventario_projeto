<?php
include('../../../conexao.php');

// Verificar a conexão com o banco de dados
if (!$conn) {
    die('Erro na conexão: ' . mysqli_connect_error());
}

// Verificar se o parâmetro 'nome' foi passado pela URL
if (isset($_GET['nome'])) {
    $nome_setor = mysqli_real_escape_string($conn, $_GET['nome']);

    // Consultar as informações do setor
    $consulta = "SELECT * FROM setor WHERE nome = '$nome_setor'";
    $resultado = mysqli_query($conn, $consulta);
    if (!$resultado) {
        die('Erro na consulta de dados: ' . mysqli_error($conn));
    }

    // Verificar se o setor existe
    $setor = mysqli_fetch_assoc($resultado);
    if (!$setor) {
        die('Setor não encontrado.');
    }
} else {
    die('Nome do setor não fornecido.');
}

// Atualizar as informações do setor
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $localizacao_pai = mysqli_real_escape_string($conn, $_POST['localizacao_pai']);
    $localizacao_filho = mysqli_real_escape_string($conn, $_POST['localizacao_filho']);
    $numero_porta = mysqli_real_escape_string($conn, $_POST['numero_porta']);

    // Atualizar os dados no banco de dados
    $consulta_update = "UPDATE setor SET nome = '$nome', localizacao_pai = '$localizacao_pai', localizacao_filho = '$localizacao_filho', numero_porta = '$numero_porta' WHERE nome = '$nome_setor'";
    if (mysqli_query($conn, $consulta_update)) {
        // Redirecionar de volta para a página principal com uma mensagem de sucesso
        header('Location: index.php?mensagem=Setor atualizado com sucesso!');
        exit;
    } else {
        echo 'Erro ao atualizar o setor: ' . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventário de TIC edição de setor</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

            <!-- Script para carregar os subsetores-->

            <script>
            function fetchSublocalizacoes() {
                var localizacaoPai = document.getElementById('localizacao_pai').value;
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'get_sublocalizacoes.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        document.getElementById('localizacao_filho').innerHTML = xhr.responseText;
                        document.getElementById('setores').innerHTML = '<option value="">Selecione uma sublocalização</option>';
                    }
                };
                xhr.send('localizacao_pai=' + encodeURIComponent(localizacaoPai));
            }
    
            function fetchSetores() {
                var localizacaoPai = document.getElementById('localizacao_pai').value;
                var localizacaoFilho = document.getElementById('localizacao_filho').value;
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'get_setores.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        document.getElementById('setores').innerHTML = xhr.responseText;
                    }
                };
                xhr.send('localizacao_pai=' + encodeURIComponent(localizacaoPai) + '&localizacao_filho=' + encodeURIComponent(localizacaoFilho));
            }
        </script>

</head>

<body>
    <header>
        <nav>
            <img src="../../../assets/logo/logo.png" alt="logo" class="logo">
            <h1>INVTIC - edição de setor</h1>
            <ul>
                <li><a href="../">Voltar</a></li>
            </ul>
        </nav>
    </header>

    <main class="main">
        <div class="options-container">

        <h2>Editar Setor</h2>

            <form method="POST">
                <label for="nome">Nome do Setor:</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($setor['nome']); ?>" required>
                <br>
                    <label for="localizacao_pai">Localização Pai:</label>
                    <select id="localizacao_pai" name="localizacao_pai" onchange="fetchSublocalizacoes()">
                        <option value="">Selecione uma localização</option>
                        <?php
                        // Conectar ao banco de dados
                        $host = '10.1.10.100';
                        $dbname = 'inventario_icom';
                        $username = 'suporte';
                        $password = 'p@$$.cmicom2871';
                        $conn = new mysqli($host, $username, $password, $dbname);
                        if ($conn->connect_error) {
                            die("Conexão falhou: " . $conn->connect_error);
                        }
            
                        // Obter localizações pai
                        $sql = "SELECT DISTINCT localizacao_pai FROM setor";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value=\"" . htmlspecialchars($row['localizacao_pai']) . "\">" . htmlspecialchars($row['localizacao_pai']) . "</option>";
                        }
                        $conn->close();
                        ?>
                    </select>
                    <br>
                    <label for="localizacao_filho">Localização Filho:</label>
                        <select id="localizacao_filho" name="localizacao_filho" onchange="fetchSetores()">
                            <option value="">Selecione uma localização pai primeiro</option>
                        </select>
                        <br>

                <label for="numero_porta">Número da Porta:</label>
                <input type="text" id="numero_porta" name="numero_porta" value="<?php echo htmlspecialchars($setor['numero_porta']); ?>" required>
                <br>

                <button type="submit">Salvar Alterações</button>
            </form>
        </div>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2024 Inventário de ativos de TIC. Todos os direitos reservados.</p>
            <p>Desenvolvido por Alberto Nascimento - Engenheiro de computação e desenvolvedor de softwares WEB</p>
        </div>
    </footer>

        <!-- Script para alerta e limpar formulário -->
        <script>
            $(document).ready(function() {
                $('#cadastro-form').on('submit', function(event) {
                    event.preventDefault(); // Evita o comportamento padrão
                    alert('Formulário enviado com sucesso!');
                    this.reset(); // Limpa o formulário
                });
            });
        </script>

</body>
</html>
