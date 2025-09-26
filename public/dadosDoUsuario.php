<?php
    include "../db.php"

    
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dados do Usuário</title>
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.12.1/font/bootstrap-icons.min.css">
    <script src="../script/navBar.js"></script>
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
    <br>
    <main>
        <div class="dadosUsuario">
             <h1>*Nome <?php echo htmlspecialchars($nome_usuario['nome_usuario']); ?></h1>
             <div class="flex">
                <i class="bi bi-person-fill"></i>
                <div class="textoDadosUsuario">
                  <h2>Email</h2>
                  <h2>Função</h2>
              </div>
          </div>
        </div>
    <h1 class="configuracoesDados">Configurações</h1>
    <div class="configuracoesDados">
        
        <a href="geral.php" class="iconDadosUsuario">
        <i class="bi bi-gear-fill"></i>
        <h2>Geral</h2>
        </a>
        <a href="seguranca.php" class="iconDadosUsuario">
        <i class="bi bi-shield-fill-check"></i>
        <h2>Seguranças</h2>
        </a>
        <a href="acessibilidade.php" class="iconDadosUsuario">
        <i class="bi bi-universal-access-circle"></i>
        <h2>Acessibilidade</h2>
        </a> 
        <a href="logout.php?logout=true" class="iconDadosUsuario">
        <i class="bi bi-box-arrow-left"></i>
        <h2>Sair</h2>
        </a>

    </div>
    </main>


    
</body>
</html>