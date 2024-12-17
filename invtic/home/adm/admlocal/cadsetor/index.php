<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inventário de TIC - Cadastro de setor</title>
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
            <img src="https://vnx.partners/wp-content/uploads/2024/03/DALL%C2%B7E-2024-03-19-13.22.30-Redesign-the-cover-image-for-an-article-on-_Digital-Threats_-to-include-a-young-adult-male-model-maintaining-the-positive-and-calming-style-with-soot.webp" alt="logo" class="logo">
            <h1>INVTIC - Cadastro de setor</h1>
            <ul>
               <!-- <li><a href="../relatorios/">Relatórios gerais</a></li> -->
                <li><a href="../">Voltar</a></li>
            </ul>
        </nav>
    </header>
          
        <main class="main">
            <div class="options-container">

            <h1> Formulário de cadastro</h1>
            <br><br>

                <form action="processar_formulario.php" method="post">
                    <label for ="nome"> Nome do setor: </label>
                    <input type="text" id="nome" name="nome" required>
                    <!-- Nome do responsável por o setor: <input type="text" id="nome_responsavel" name="nome_responsavel"> -->
                    <!-- Número do ramal: <input type="number" id="ramal_setor" name="ramal_setor"> -->
                    <br>
                    <label for ="number"> Número da porta: </label>
                    <input type="number" id="numero_porta" name="numero_porta">
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
                        <br><br>
                    <br><br>
                    <input type="submit" value="enviar">
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