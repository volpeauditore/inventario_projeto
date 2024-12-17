<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Localizações</title>
    <link rel="stylesheet" href="styles.css">
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
            <img src="../assets/logo/logo.png" alt="logo" class="logo">
            <h1>Sistema WEB de Inventário de TIC</h1>
            <ul>
                <li><a href="../">Sair</a></li>
            </ul>
        </nav>
    </header>

    <main>
    <h1>Localizações</h1>
    <form>
        <label for="localizacao_pai">Localização Pai:</label>
        <select id="localizacao_pai" name="localizacao_pai" onchange="fetchSublocalizacoes()">
            <option value="">Selecione uma localização</option>
            <?php
            // Conectar ao banco de dados
            include ("../conexao.php");

            // Obter localizações pai
            $sql = "SELECT DISTINCT localizacao_pai FROM setor";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<option value=\"" . htmlspecialchars($row['localizacao_pai']) . "\">" . htmlspecialchars($row['localizacao_pai']) . "</option>";
            }
            $conn->close();
            ?>
        </select>
        <br><br>
        <label for="localizacao_filho">Localização Filho:</label>
        <select id="localizacao_filho" name="localizacao_filho" onchange="fetchSetores()">
            <option value="">Selecione uma localização pai primeiro</option>
        </select>
        <br><br>
        <label for="setores">Setores:</label>
        <div id="setores">
            <option value="">Selecione uma sublocalização</option>
        </div>
    </form>
        </main>

    <footer>
        2024 - Inventário de TIC (InvTIC)
    </footer>

</body>
</html>
