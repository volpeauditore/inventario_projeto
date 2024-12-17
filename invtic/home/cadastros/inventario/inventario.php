<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Inventário</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function fetchMarcasAndModelos() {
            var tipoEquipamento = document.getElementById('tipo_equipamento').value;
            var setor = document.getElementById('setor').value;
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'get_marcas_modelos.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    var marcaSelect = document.getElementById('marca');
                    var modeloSelect = document.getElementById('modelo');

                    // Limpar opções anteriores
                    marcaSelect.innerHTML = '<option value="">Selecione uma marca</option>';
                    modeloSelect.innerHTML = '<option value="">Selecione um modelo</option>';

                    // Adicionar novas opções de marca
                    response.marcas.forEach(function(marca) {
                        var option = document.createElement('option');
                        option.value = marca;
                        option.text = marca;
                        marcaSelect.add(option);
                    });

                    // Adicionar novas opções de modelo
                    response.modelos.forEach(function(modelo) {
                        var option = document.createElement('option');
                        option.value = modelo;
                        option.text = modelo;
                        modeloSelect.add(option);
                    });
                }
            };
            xhr.send('tipo_equipamento=' + encodeURIComponent(tipoEquipamento) + '&setor=' + encodeURIComponent(setor));
        }

        function toggleTelefoneFields() {
            var tipoEquipamento = document.getElementById('tipo_equipamento').value;
            var telefoneFields = document.getElementById('telefone_fields');
            if (tipoEquipamento === 'telefone') {
                telefoneFields.style.display = 'block';
            } else {
                telefoneFields.style.display = 'none';
            }
        }

        window.onload = function() {
            document.getElementById('tipo_equipamento').addEventListener('change', function() {
                fetchMarcasAndModelos();
                toggleTelefoneFields();
            });
        }
    </script>
</head>
<body>

<header>
    <nav>
        <img src="../../assets/logo/logo.png" class="logo" alt="Logo">
        <h1>Formulário para Inventário</h1>
        <ul>
            <li><a href="../home.php">Voltar</a></li>
        </ul>
    </nav>
</header>

<div class="opcoes">

    <?php
        // Sanitização do valor do setor obtido via GET
        $setor = isset($_GET['setor']) ? htmlspecialchars($_GET['setor']) : '';
    ?>

    <form action="processar_formulario.php" method="post">
        <br><br>
        <label for="tipo_equipamento">Selecione o tipo de equipamento:</label>
        <select name="tipo_equipamento" id="tipo_equipamento" required>
            <option value="">Selecione um tipo</option>
            <option value="computador">Computador</option>
            <option value="monitor">Monitor</option>
            <option value="notebook">Notebook</option>
            <option value="telefone">Telefone</option>
            <option value="tablet">Tablet</option>
            <option value="impressora">Impressora</option>
            <option value="scanner">Scanner</option>
            <option value="estabilizador">Estabilizador</option>
            <option value="filtro de linha">Filtro de Linha</option>
            <!-- Adicione outros tipos conforme necessário -->
        </select>
        <br><br>
        
        <label for="setor">Nome do setor:</label>
        <input type="text" id="setor" name="setor" value="<?php echo $setor; ?>" required readonly>
        <br><br>



        <label for="marca">Selecione a marca do equipamento:</label>
        <select name="marca" id="marca" required>
            <option value="">Selecione uma marca</option>
        </select>
        <br><br>

        <label for="modelo">Selecione o modelo do equipamento:</label>
        <select name="modelo" id="modelo" required>
            <option value="">Selecione um modelo</option>
        </select>
        <br><br>

        <div id="telefone_fields" style="display: none;">
            <label for="ramal">Número do ramal:</label>
            <input type="number" id="ramal" name="ramal">
            <br><br>

            <label for="mac_ramal">MAC do ramal:</label>
            <input type="text" id="mac_ramal" name="mac_ramal">
            <br><br>

            <label for="ip_ramal">IP do ramal:</label>
            <input type="text" id="ip_ramal" name="ip_ramal">
            <br><br>
        </div>

        <br><br>

        <div id="pat_fields">
            <label for="patrimonio">Patrimônio:</label>
            <input type="number" id="patrimonio" name="patrimonio">
            <br><br>

            <input type="checkbox" id="n/a" name="n/a" value="n/a">
            <label for="n/a">Não identificado</label><br>
        </div>

        <br><br>

        <label for="quantidade">Quantidade:</label>
        <input type="number" id="quantidade" name="quantidade">
        <br><br>        

        <label for="observacoes">Observações:</label>
        <textarea id="observacoes" name="observacoes"></textarea>
        <br><br>

        <input type="submit" value="Enviar">
        <br><br>
    </form>

</div>

<footer>Design em desenvolvimento</footer>

</body>
</html>
