<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php 
        $page_titles = [
            'cadastrarTrem.php' => 'Cadastrar Trem',
            'consumodeEnergia.php' => 'Consumo de Energia',
            'funcionarios.php' => 'Funcionários',
            'notificacoes.php' => 'Notificações',
            'dadosDoUsuario.php' => 'Dados do Usuário',
            'termos_de_uso.php' => 'Termos de Uso',
            'ajuda.php' => 'Ajuda',
            'mapa.php' => 'Mapa',
            'trens.php' => 'Trens',
            'seguranca.php' => 'Segurança',
            'configuracoes.php' => 'Configurações'            
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
        <?php?>
        <h1><?php echo ($page_titles[$current_page] ?? 'Sistema'); ?></h1>
        <button class="nav-button" onclick="alternarMenu()">
            <i class="bi bi-list"></i>
        </button>
        <div class="menu" id="menu">
            <button class="close-button" onclick="alternarMenu()">X</button>
            <a href="mapa.php">Mapa</a>
            <a href="dadosDoUsuario.php">Dados do Usuário</a>
            <a href="trens.php">Trens</a>
            <?php
              if(isset($_SESSION['funcao_usuario']) && $_SESSION['funcao_usuario'] == 'administrador'){
                  echo "<a href='funcionarios.php'>Funcionários</a>";
              }
            ?>
        </div>
        </div>
    </header>
</body>
</html>