<?php include "header.php"; ?>
    <main>
      <div class="paginaAcessibilidade">
        <h1>
          <i class="bi bi-universal-access-circle"></i> Acessibilidade
        </h1>

        <div class="blocoCores">
          <h2>Ajustes de cores</h2>
          <div class="grupoBotoesCores">
            <button onclick="aplicarTema('normal')">Padrão</button>
            <button onclick="aplicarTema('deuteranopia')">Deuteranopia</button>
            <button onclick="aplicarTema('protanopia')">Protanopia</button>
            <button onclick="aplicarTema('tritanopia')">Tritanopia</button>
          </div>
        </div>

        <div class="blocoAjuda">
          <p>Precisa de mais alguma ajuda?</p>
          <a href="#">clique aqui</a>
        </div>
      </div>
    </main>

    <script>
      function aplicarTema(tipo) {
        switch (tipo) {
          case 'deuteranopia':
            document.body.style.filter = 'hue-rotate(20deg) contrast(1.1)';
            break;
          case 'protanopia':
            document.body.style.filter = 'hue-rotate(270deg) contrast(1.1)';
            break;
          case 'tritanopia':
            document.body.style.filter = 'hue-rotate(90deg) contrast(1.1)';
            break;
          default:
            document.body.style.filter = 'none';
        }
      }
    </script>
</body>
</html>
