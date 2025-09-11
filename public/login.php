<?php
    #include ../db.php
    $mysqli = new mysqli("localhost", "root", "root", "tlb_sa");
    if ($mysqli->connect_errno) {
        die("Erro de conexão: " . $mysqli->connect_error);
    }

    session_start();

    if (isset($_GET['logout'])) {
        session_destroy();
        header("Location: login.php");
        exit;
    }

    $msg = "";
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $user = $_POST["username"] ?? "";
        $pass = $_POST["password"] ?? "";

        $stmt = $mysqli->prepare("SELECT id, username, senha FROM usuarios WHERE username=? AND senha=?");
        $stmt->bind_param("ss", $user, $pass);
        $stmt->execute();
        $result = $stmt->get_result();
        $dados = $result->fetch_assoc();
        $stmt->close();

        if ($dados) {
            $_SESSION["user_id"] = $dados["id"];
            $_SESSION["username"] = $dados["username"];
            header("Location: login.php");
            exit;
        } else {
            $msg = "Usuário ou senha incorretos!";
        }
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
                <?php if ($msg): ?><p class="msg"><?= $msg ?></p><?php endif; ?>
                <form method="post" id="loginForm">
                    <div class="inputContainer">
                        <input type="text" id="nome" name="nome" placeholder="usuário">
                    <i class="bi bi-person-fill"></i>
                    </div>
                    
                    <div class="inputContainer">
                        <label for="senha"></label>
                        <input type="password" id="senha" name="senha"  placeholder="senha">
                        <i class="bi bi-lock-fill"></i>
                    </div><br>
                    <a href="esqueceu.html">Esqueceu a Senha?</a>
                    <br>
                    <br>
                    <a href="mapa.html" class="buttonRoxoLogin">Entrar</a>
                    <a href="cadastro.html" class="buttonRoxoLogin">Cadastrar-se</a>
                    <button type="submit">Entrar</button>
                </form>
                
            </div>
        </div>
    </section>
</body>

</html>