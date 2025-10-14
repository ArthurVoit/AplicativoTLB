<?php


include "../db.php";
session_start();

$register_msg = "";

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['register'])){
    $novo_usuario = $_POST['novo_usuario'] ?? "";
    $novo_email = $_POST['novo_email'] ?? "";
    $nova_senha = $_POST['nova_senha'] ?? "";
    $confirmar_senha = $_POST['confirmar_senha'] ?? "";
    
    if($nova_senha !== $confirmar_senha){
        $register_msg = "As senhas não coincidem!";
    }

    elseif($novo_usuario && $nova_senha && $novo_email){

        $nova_func = 'normal';
        
        $stmt = $conn->prepare("INSERT INTO usuario (nome_usuario, email_usuario, senha_usuario, funcao_usuario) VALUES (?,?,?,?)");
        $stmt->bind_param("ssss", $novo_usuario, $novo_email, $nova_senha, $nova_func);
        
        if($stmt->execute()) {
            $register_msg = "Usuário cadastrado com sucesso!";
            $novo_usuario = $novo_email = $nova_senha = $confirmar_senha = "";
        } else {
            $register_msg = "Erro ao cadastrar novo usuário: " . $stmt->error;
        };
        $stmt->close();
    } else {
        $register_msg = "Preencha todos os campos.";
    };
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../styles/style.css">
    <script src="../script/scriptCadastro.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.12.1/font/bootstrap-icons.min.css">
</head>

<body class="bodyTelaCadastro">
    <section class="cadastro">
        <div class="formCadastro">
            <a href="login.php"><i class="bi bi-arrow-left-circle"></i></a>
            <form method="post" id="formcadastro">
                <br>
                <br>
                <div class="inputContainer">
                    <?php if($register_msg): ?> 
                        <p class="<?php echo strpos($register_msg, 'sucesso') !== false ? 'success-msg' : 'error-msg'; ?>"> 
                            <?= $register_msg ?> 
                        </p> 
                    <?php endif; ?>
                    <br>
                    <br>
                    <input type="text" id="novo_usuario" name="novo_usuario" required placeholder="usuário" value="<?php echo htmlspecialchars($novo_usuario ?? ''); ?>">
                    <i class="bi bi-person-fill"></i>
                </div>
                <br>
                <div class="inputContainer">
                    <label for="novo_email"></label>
                    <input type="email" id="novo_email" name="novo_email" required placeholder="email" value="<?php echo htmlspecialchars($novo_email ?? ''); ?>">
                    <i class="bi bi-at"></i>
                </div>
                <br>
                <div class="inputContainer">
                    <label for="nova_senha"></label>
                    <input type="password" id="nova_senha" name="nova_senha" required placeholder="senha">
                    <i class="bi bi-lock-fill"></i>
                </div>
                <br>
                <div class="inputContainer">
                    <label for="confirmar_senha"></label>
                    <input type="password" id="confirmar_senha" name="confirmar_senha" required placeholder="confirmar senha">
                    <i class="bi bi-lock-fill"></i>
                </div>
                <br>
                <br>
                <button class="buttonRoxoCadastro" type="submit" name="register" value="1">Cadastrar-se</button>
            </form>
            <p class="pCadastro">Ao clicar você estará de acordo com as políticas da empresa</p>
            <a href="politicas.php">Ver políticas</a>
        </div>
    </section>
</body>
</html>