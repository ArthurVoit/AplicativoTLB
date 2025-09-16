<?php

#include ../db.php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome = $_POST['nome_usuario'];
    $email = $_POST['email_usuario'];
    $senha = $_POST['senha_usuario'];
    $confirmar_senha = $_POST['confirmar_senha'];

    $sql = " INSERT INTO usuario (nome_usuario, email_usuario, senha_usuario) VALUEs ('$nome', '$email', '$senha')";

    if ($conn->query($sql) === true) {
        echo "Novo registro criado com sucesso.";
    } else {
        echo "Erro " . $sql . '<br>' . $conn->error;
    }
    $conn->close();
}

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
            <form action="" id="formcadastro">
                <br>
                <br>
                <div class="inputContainer">
                    <input type="text" id="nome_usuario" name="nome_usuario" required placeholder="usuário">
                <i class="bi bi-person-fill"></i>
                </div>
                <br>
                <div class="inputContainer">
                    <label for="email_usuario"></label>
                    <input type="email" id="email_usuario" name="email_usuario" required placeholder="email">
                    <i class="bi bi-at"></i>
                </div>
                <br>
                <div class="inputContainer">
                    <label for="senha_usuario"></label>
                    <input type="password" id="senha_usuario" name="senha_usuario" required placeholder="senha">
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
                <button class="buttonRoxoCadastro" type="submit">Cadastrar-se</button>
            </form>
            <p class="pCadastro">Ao clicar você estará de acordo com as políticas da empresa</p>
            <a href="politicas.php">Ver políticas</a>
        </div>
    </section>
</body>
</html>