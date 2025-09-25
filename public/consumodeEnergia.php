<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios e Análises</title>
    <link rel="stylesheet" href="../styles/style.css">
    <script src="../script/navBar.js"></script>
</head>
<body class="bodyRelatorios">
    <header>
        <div class="navbar">
        <div class="btnNavBar"><a href="notificacao.php"><img src="../assets/icons/bell.svg" alt=""></a></div>
        <h1>Dados do Usuário</h1>
        <button class="nav-button" onclick="alternarMenu()"> ≡</button>
        <div class="menu" id="menu">
            <button class="close-button" onclick="alternarMenu()">X</button>
            <a href="mapa.php">Mapa</a>
            <a href="dadosDoUsuario.php">Dados do Usuário</a>
            <a href="relatorios.php">Relatórios</a>
            <a href="consumodeEnergia.php">Consumo de Energia</a>
            <a href="monitoramentoManutencao.php">Monitoramento e Manutenção</a>
            <a href="eficienciaOperacional.php">Eficiência Operacional</a>
        </div>
        </div>
    </header>
    <div class="grafico-container">
        <div id="chart3"></div>
    </div>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        google.charts.load('current', { packages: ['corechart'] });
        google.charts.setOnLoadCallback(drawResponsiveChart);

        let chart, data;

        function drawResponsiveChart() {
            const container = document.getElementById('chart3');

            data = google.visualization.arrayToDataTable([
                ['Período', 'Consumo(kWh)'],
                ['Dia', 125],
                ['Tarde', 250],
                ['Noite', 625]
            ]);

            drawChart(container.offsetWidth);
            }

            function drawChart(width) {
            const container = document.getElementById('chart3');

            const options = {
                title: 'Consumo de: Hoje',
                height: 400,
                width: width
            };

            chart = new google.visualization.ColumnChart(container);
            chart.draw(data, options);
            }

            
            window.addEventListener('resize', () => {
            const container = document.getElementById('chart3');
            drawChart(container.offsetWidth);
            });


    </script>
</body>
</html>


