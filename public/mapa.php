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
    
    <!-- Botão S1 com posicionamento correto -->
    <div class="tooltip-container btn-s1">
        <button class="btn-mapa">S1</button>
        <span class="tooltip-text">
            SENSOR DE DISTANCIA<br>
            SENSOR DE UMIDADE<br>
            SENSOR DE LUMINOSIDADE
        </span>
    </div>
    <div class="tooltip-container btn-s2">
        <button class="btn-mapa">S2</button>
        <span class="tooltip-text">
            SENSOR DE DISTANCIA<br>
            SENSOR DE UMIDADE<br>
            SENSOR DE LUMINOSIDADE
        </span>
    </div>
    <div class="tooltip-container btn-s3">
        <button class="btn-mapa">S3</button>
        <span class="tooltip-text">
            SENSOR DE DISTANCIA<br>
            SENSOR DE UMIDADE<br>
            SENSOR DE LUMINOSIDADE
        </span>
    </div>

</section>

</body>
</html>