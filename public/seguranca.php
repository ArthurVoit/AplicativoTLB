<?php
    include "../db.php";
    session_start();

    if (!isset($_SESSION['id_usuario'])) {
        header("Location: login.php");
        exit;
    }
?>
<?php include "header.php"; ?>
    <main>
        <div class="paginaSeguranca">
            <h1>
            <i class="bi bi-shield-lock-fill"></i> Configurações de Segurança
            </h1>

            <div class="blocoSenha">
            <h2>Senha</h2>
            <a href="alterar.php" class="link">
            <button class="btnSenha">
            <i class="bi bi-key-fill"></i> Alterar dados
            </button>
            </a>
            </div>
        </div>
    </main>
</body>
</html>
