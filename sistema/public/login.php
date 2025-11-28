<?php
    include "../db.php";

    session_start();

    $cadastro_sucesso = false;
    if (isset($_SESSION['cadastro_sucesso']) && $_SESSION['cadastro_sucesso']) {
        $cadastro_sucesso = true;
        unset($_SESSION['cadastro_sucesso']);
    }

    if (isset($_GET['logout'])) {
        session_destroy();
        header("Location: login.php");
        exit;
    }

    $msg = "";
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $user = $_POST["nome_usuario"] ?? "";
        $pass = $_POST["senha_usuario"] ?? "";

        $stmt = $conn->prepare("SELECT id_usuario, nome_usuario, senha_usuario, funcao_usuario FROM usuario WHERE nome_usuario=?");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();
        $dados = $result->fetch_assoc();
        
        if($dados && password_verify($pass, $dados['senha_usuario'])){
            $_SESSION['id_usuario'] = $dados['id_usuario'];
            $_SESSION["nome_usuario"] = $dados["nome_usuario"];
            $_SESSION["senha_usuario"] = $dados["senha_usuario"];
            $_SESSION["funcao_usuario"] = $dados["funcao_usuario"];
            header("Location: mapa.php");
            exit;
        } else {
            $msg = "Usuário ou senha incorretos!";
        }
        $stmt->close();
    }
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="script.js"></script>
    <link rel="stylesheet" href="../styles/style.css">
    <title>TLB Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.12.1/font/bootstrap-icons.min.css">
</head>

<body class="bodyTelalogin">
    <section class="login">
        <div class="loginForm">
            <br>
            <img id="imgLogin" src="../assets/icons/TlbLogo.png" alt="">
            <div class="usuariosenha">
                <h2>Usuário</h2>
                
                <?php if ($cadastro_sucesso): ?>
                    <div class="alert-message success">
                        <i class="bi bi-check-circle-fill"></i>
                        <div>
                            <strong>Cadastro realizado com sucesso!</strong>
                            <span>Faça login para continuar.</span>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php if ($msg): ?>
                    <div class="alert-message error">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <div>
                            <strong>Falha no login</strong>
                            <span>Verifique seu usuário e senha e tente novamente.</span>
                        </div>
                    </div>
                <?php endif; ?>
                
                <form method="post" id="loginForm">
                    <div class="inputContainer">
                        <input type="text" id="nome_usuario" name="nome_usuario" placeholder="usuário" value="<?php echo htmlspecialchars($_POST['nome_usuario'] ?? ''); ?>">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    
                    <div class="inputContainer">
                        <label for="senha_usuario"></label>
                        <input type="password" id="senha_usuario" name="senha_usuario" placeholder="senha">
                        <i class="bi bi-lock-fill"></i>
                    </div>
                    <br>
                    <a href="esqueceu.html">Esqueceu a Senha?</a>
                    <br>
                    <br>
                    <button type="submit" class="buttonRoxoLogin">Entrar</button>
                    <a href="cadastro.php" class="buttonRoxoLogin">Cadastrar-se</a>
                </form>
                
            </div>
        </div>
    </section>
</body>

</html>