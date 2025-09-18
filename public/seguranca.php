<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Segurança</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="../styles/style.css">
  <script src="../script/navBar.js"></script>
</head>
<body>
    <header>
        <div class="navbar">
        <div class="btnNavBar"><a href="notificacao.html"><img src="../assets/icons/bell.svg" alt=""></a></div>
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
        <div class="paginaSeguranca">
            <h1>
            <i class="bi bi-shield-lock-fill"></i> Configurações de Segurança
            </h1>

            <div class="blocoSenha">
            <h2>Senha</h2>
            <button class="btnSenha">
            <i class="bi bi-key-fill"></i> Alterar senha
            </button>
            </div>
        </div>
    </main>
</body>
</html>
