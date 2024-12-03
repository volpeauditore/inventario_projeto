<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: /invtic/");
    exit();
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page InTIC</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <header>
        <nav>
            <img src="assets/logo/logo.png" alt="logo" class="logo">
            <h1>Sistema WEB de Inventário de TIC</h1>
            <ul>
                <li><a href="../">Sair</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="opcoes">
            <a href="cadastros/home.php" class="card">Realização de Inventário</a>
            <a href="checagem/home.php" class="card">Checagem por Setor</a>
            <a href="adm/" class="card">Administração da Plataforma</a>
            <a href="relatorios/" class="card">Relatórios de Inventário</a>
        </div>

        <br>

        <div class="graficos">
            <canvas id="inventarioChart" width="400" height="200"></canvas>
        </div>
    </main>

    <footer>
        Inventário de TIC (InvTIC)
    </footer>

    <script>
        function loadChart() {
            fetch('consulta.php')
                .then(response => response.json())
                .then(data => {
                    const tipos = data.map(item => item.tipo_equipamento);
                    const quantidades = data.map(item => parseInt(item.quantidade, 10));

                    const ctx = document.getElementById('inventarioChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: tipos,
                            datasets: [{
                                label: 'Quantidade por Tipo de Equipamento',
                                data: quantidades,
                                backgroundColor: ['#50b3ff', '#ff7979', '#f9ca24', '#badc58', '#ffbe76'],
                                borderColor: '#130f40',
                                borderWidth: 2,
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                legend: {
                                    labels: {
                                        font: {
                                            size: 14,
                                            family: 'Poppins',
                                            weight: 'bold'
                                        }
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Erro ao carregar os dados:', error));
        }

        window.onload = loadChart;
    </script>
</body>
</html>
