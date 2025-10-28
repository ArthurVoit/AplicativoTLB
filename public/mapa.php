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

    
    <script type="importmap">
        {
            "imports": {
                "three": "https://cdn.jsdelivr.net/npm/three@0.177.0/build/three.module.js",
      "jsm/": "https://cdn.jsdelivr.net/npm/three@0.177.0/examples/jsm/"
    }
        }
    </script>
    <script type = "module" src="../script/map.js"></script>
    </div> 
    <br>
    <canvas class="temaMapa container" id="map">
        <br>
    </section>
    <section class="verdeSct">
        <div class="flex center ">
                <input type="image" src="../assets/icons/speeddometter.png" align = "center">
            <input type="image" src="../assets/icons/ReportBttn.png" align = "center">
        </div>
    </section>


</body>

</html>