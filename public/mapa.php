<?php
    include "../db.php";
    session_start();

    if (!isset($_SESSION['id_usuario'])) {
        header("Location: login.php");
        exit;
    }

    echo "<!-- DEBUG: Função do usuário: " . ($_SESSION['funcao_usuario'] ?? 'não definida') . " -->";
    include "header.php";
?>

<section class="mapaAlterado">
    <br>
    <img src="../assets/img/mapaSA.png" alt="Mapa">

    <div class="tooltip-container btn-s1">
        <button class="btn-mapa">S1</button>
        <span class="tooltip-text" id="sensor-s1">
            Carregando...
        </span>
    </div>
    <div class="tooltip-container btn-s1">
        <button class="btn-mapa">S1</button>
        <span class="tooltip-text" id="sensor-s2">
            Carregando...
        </span>
    </div>
    <div class="tooltip-container btn-s2">
        <button class="btn-mapa">S2</button>
        <span class="tooltip-text" id="sensor2-s2">
            Carregando...
        </span>
    </div>
    <div class="tooltip-container btn-s3">
        <button class="btn-mapa">S3</button>
        <span class="tooltip-text" id="sensor-s3">
            Carregando...
        </span>
    </div>

</section>

<script src="https://unpkg.com/mqtt/dist/mqtt.min.js"></script>
<script>


const client = mqtt.connect('35fb7bd345d640388502e0816b515952.s1.eu.hivemq.cloud:8883'); // Exemplo: wss://meubroker.com:8083/mqtt

client.on('connect', function () {
    client.subscribe('S1/P1');
    client.subscribe('S2/P1');
    client.subscribe('S2/P2');
    client.subscribe('S3/P1');
});

client.on('message', function (topic, message) {
    if (topic === 'S1/P1') {
        document.getElementById('sensor-s1').innerHTML = message.toString();
    }
    if (topic === 'S2/P1') {
        document.getElementById('sensor-s2').innerHTML = message.toString();
    }
    if (topic === 'S2/P2') {
        document.getElementById('sensor2-s2').innerHTML = message.toString();
    }
    if (topic === 'S3/P1') {
        document.getElementById('sensor-s3').innerHTML = message.toString();
    }
});
</script>

</body>
</html>