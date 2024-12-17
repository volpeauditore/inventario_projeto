<?php
// Conectar ao banco de dados
$host = '10.1.10.100'; // Endereço do servidor de banco de dados
$dbname = 'inventario_icom'; // Nome do banco de dados
$username = 'suporte'; // Nome de usuário do banco de dados
$password = 'p@$$.cmicom2871'; // Senha do banco de dados

// Cria uma conexão com o banco de dados
$conn = new mysqli($host, $username, $password, $dbname);

// Verifica se houve um erro na conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obtém os dados do formulário
$nome = $_POST['nome'];
$nome_responsavel = $_POST['nome_responsavel'];
$ramal_setor = $_POST['ramal_setor'];
$localizacao_pai = $_POST['localizacao_pai'];
$localizacao_filho = $_POST['localizacao_filho'];
$numero_porta = $_POST['numero_porta'];

// Prepara a consulta SQL para inserir os dados
$sql = "INSERT INTO setor (nome, nome_responsavel, ramal_setor, localizacao_pai, localizacao_filho, numero_porta) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// Certifique-se de que o tipo de dados corresponde às suas variáveis
// 's' para strings e 'i' para inteiros
$stmt->bind_param("ssisss", $nome, $nome_responsavel, $ramal_setor, $localizacao_pai, $localizacao_filho, $numero_porta );

// Executa a consulta e verifica se foi bem-sucedida
if ($stmt->execute()) {
    echo "Item adicionado com sucesso!";
} else {
    echo "Erro: " . $stmt->error;
}

// Fecha a conexão com o banco de dados
$stmt->close();
$conn->close();
?>
