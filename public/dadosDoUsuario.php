<?php
    include "../db.php";
    session_start();

    if (!isset($_SESSION['id_usuario'])) {
        header("Location: login.php");
        exit;
    }

    $id_usuario = $_SESSION['id_usuario'];
    
    $sql = "SELECT nome_usuario, email_usuario, funcao_usuario, telefone_usuario FROM usuario WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $dados_usuario = $result->fetch_assoc();
        $nome_usuario = $dados_usuario['nome_usuario'];
        $email_usuario = $dados_usuario['email_usuario'];
        $funcao_usuario = $dados_usuario['funcao_usuario'];
        $telefone_usuario = $dados_usuario['telefone_usuario'];
    } else {
        $nome_usuario = "Usuário não encontrado";
        $email_usuario = "N/A";
        $funcao_usuario = "N/A";
        $telefone_usuario = "N/A";
    }

    echo "<!-- DEBUG: Função do usuário: " . ($_SESSION['funcao_usuario'] ?? 'não definida') . " -->";
    
    $stmt->close();

?>

<?php include "header.php"; ?>
    <br>
    <main>
        <div class="dadosUsuario">
             <h1><?php echo htmlspecialchars($nome_usuario); ?></h1>
             <div class="flex">
                <i class="bi bi-person-fill"></i>
                <div class="textoDadosUsuario">
                  <h2>Email: <?php echo htmlspecialchars($email_usuario); ?></h2>
                  <h2>Função: <?php echo htmlspecialchars($funcao_usuario); ?></h2>
                  <h2>Telefone: <?php echo htmlspecialchars($telefone_usuario); ?></h2>
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