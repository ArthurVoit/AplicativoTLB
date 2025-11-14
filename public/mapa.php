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

    
    <section>
        <br>
        <img src="../assets/img/mapaSA.png" alt="" >
    </section>


</body>

</html>