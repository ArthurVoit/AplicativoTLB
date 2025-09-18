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
        <div class="btnNavBar"><a href="notificacao.html"><img src="../assets/icons/bell.svg" alt=""></a></div>
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
    <div class="charts-container">
        <div id="chart" class="grafico"></div>
        </div>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        google.charts.load('current', {packages: ['corechart']});
        google.charts.setOnLoadCallback(drawChart)
        
        function drawChart() {
            const container = document.querySelector('#chart')
            const data = new google.visualization.arrayToDataTable([
                [ 'Relatórios de Manutenções e Inspeções', 'Sla' ],
                [ 'Monitorias agendadas', 125 ],
                [ 'Inspeções feitas', 250],
                [ 'Monitorias feitas', 625]
            ])
            const options = {
                title: 'Relatórios de Manutenções e Inspeções',
                height: 500,
                width: '100%',
                fontSize: 16
            }

            const chart = new google.visualization.PieChart(container)
            chart.draw(data, options)
        }
    </script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        google.charts.load('current', {packages: ['corechart']});
        google.charts.setOnLoadCallback(drawChart)
        
        function drawChart() {
            const container = document.querySelector('#chart2')
            const data = new google.visualization.arrayToDataTable([
                [ 'Relatórios de Manutenções e Inspeções', 'Sla' ],
                [ 'Monitorias agendadas', 125 ],
                [ 'Inspeções feitas', 250],
                [ 'Monitorias feitas', 625]
            ])
            const options = {
                title: 'Relatórios de Manutenções e Inspeções',
                height: 500,
                width: '100%',
                fontSize: 16
            }

            const chart = new google.visualization.PieChart(container)
            chart.draw(data, options)
        }
    </script>
</body>
</html>