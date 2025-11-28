<?php
    include "../db.php";
    session_start();

    if (!isset($_SESSION['id_usuario'])) {
        header("Location: login.php");
        exit;
    }
?>
<?php include "header.php"; ?>
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


