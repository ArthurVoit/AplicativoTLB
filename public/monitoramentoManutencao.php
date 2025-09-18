<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Relatórios e Análises</title>
  <link rel="stylesheet" href="../styles/style.css" />
  <script src="../script/navBar.js"></script>
  <style>
    #trem3D {
      width: 100vw;
      height: 100vh;
      overflow: hidden;
    }
  </style>
</head>
<body class="bodyRelatorios">
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
    <div id="trem3D"></div>
  </main>
  <script type="importmap">
    {
        "imports": {
            "three": "https://cdn.jsdelivr.net/npm/three@0.177.0/build/three.module.js",
  "jsm/": "https://cdn.jsdelivr.net/npm/three@0.177.0/examples/jsm/"
}
    }
</script>
  <script type="module" src="../script/loadModel-final.js"></script>



</body>
</html>
