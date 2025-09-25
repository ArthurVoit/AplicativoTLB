<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificações</title>
    <link rel="stylesheet" href="../styles/style.css">
    <script src="../script/navBar.js"></script>
    <script src="../script/notificacao.js"></script>
</head>
<body>
    <header>
        <div class="navbar">
        <div class="btnNavBar"><a href="notificacao.php"><img src="../assets/icons/bell.svg" alt=""></a></div>
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