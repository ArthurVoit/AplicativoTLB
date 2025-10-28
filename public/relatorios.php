<?php


    include "../db.php";
    session_start();

    if (!isset($_SESSION['id_usuario'])) {
        header("Location: login.php");
        exit;
    }
?>
<?php include "header.php"; ?>
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