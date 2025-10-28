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
      <div class="topico" onclick="alternarNotificacoes(this)">
        <span>Gerenciamento do Trem</span>
        <img src="../assets/icons/seta2.png" class="seta" alt="Seta">
      </div>
      <div class="notificacoes">
        <p>- É necessário agendar um reparo para o trem</p>
        <p>- Alerta sobre a gestão do uso do combustível</p>
      </div>
      <div class="topico" onclick="alternarNotificacoes(this)">
        <span>Avisos Sobre Atraso</span>
        <img src="../assets/icons/seta2.png" class="seta" alt="Seta">
      </div>
      <div class="notificacoes">
        <p>- Tivemos um problema nos trilhos...</p>
        <p>- A locomotiva esta indo mais lento que o normal...</p>
      </div>
      <div class="topico" onclick="alternarNotificacoes(this)">
        <span>Atualizações de Segurança</span>
        <img src="../assets/icons/seta2.png" class="seta" alt="Seta">
      </div>
      <div class="notificacoes">
        <p>- Servidor fora do ar às 14:32</p>
        <p>- Os trilhos foram reparados recentemente.</p>
      </div>
    </main>

</body>
</html>