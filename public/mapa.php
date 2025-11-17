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

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="bodyMapa">

<section class="mapaAlterado">
    <br>
    <img src="../assets/img/mapaSA.png" alt="Mapa" style="position: relative;">
    
    <!-- Botão S1 com posicionamento correto -->
    <div class="tooltip-container" style="position: absolute; top: 30%; left: 45%;">
        <button class="btn-mapa btn-s1">S1</button>
        <span class="tooltip-text">
            SENSOR DE DISTANCIA<br>
            SENSOR DE UMIDADE<br>
            SENSOR DE LUMINOSIDADE
        </span>
    </div>
    
    <!-- Adicione mais botões conforme necessário -->
    <!--
    <div class="tooltip-container" style="position: absolute; top: X%; left: Y%;">
        <button class="btn-mapa">S2</button>
        <span class="tooltip-text">
            Informações do sensor S2
        </span>
    </div>
    -->
</section>

</body>
</html>