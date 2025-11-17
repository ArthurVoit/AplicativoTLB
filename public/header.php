<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php 
        $page_titles = [
            'cadastrarTrem.php' => 'Cadastrar Trem',
            'consumodeEnergia.php' => 'Consumo de Energia',
            'funcionarios.php' => 'Funcionarios',
            'notificacoes.php' => 'Notificações',
            'dados.php' => 'Configurações',
            'termos_de_uso.php' => 'Termos de Uso',
            'ajuda.php' => 'Ajuda',
            'mapa.php' => 'Mapa',
            
        ];
        $current_page = basename($_SERVER['PHP_SELF']);
        echo ($page_titles[$current_page] ?? 'Sistema') . ' - TLB';
    ?></title>
    <link rel="stylesheet" href="../styles/style.css">
    <script src="../script/navBar.js"></script>
    <script src="../script/notificacao.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
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
            <?php
              if(isset($_SESSION['funcao_usuario']) && $_SESSION['funcao_usuario'] == 'administrador'){
                  echo "<a href='funcionarios.php'>Funcionários</a>";
              }
            ?>
        </div>
        </div>
    </header>