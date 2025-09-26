<?php

include '../db.php';

session_start();

$id = $_SESSION['id_usuario'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = $_POST['name'];
    $email = $_POST['email'];

    $sql = "UPDATE usuario SET nome_usuario ='$name', email_usuario ='$email' WHERE id=$id";

    if ($conn->query($sql) === true) {
        echo "Registro atualizado com sucesso.
        <a href='geral.php'>Voltar as configurações.</a>
        ";
    } else {
        echo "Erro " . $sql . '<br>' . $conn->error;
    }
    $conn->close();
    exit(); 
}

$sql = "SELECT * FROM usuario WHERE id_usuario=$id";
$result = $conn -> query($sql);
$row = $result -> fetch_assoc();


?>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>update</title>
</head>

<body>

    <form method="POST" action="update.php?id=<?php echo $row['id_usuario'];?>">
<p>suas informações</p>
        <label for="name">Nome:</label>
        <input type="text" name="name" value="<?php echo $row['nome_usuario'];?>" required>
<br>
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $row['email_usuario'];?>" required>
<br>
        <label for="Telefone">Telefone:</label>
        <input type="text" name="telefone" value="<?php echo $row['telefone_usuario'];?>" required>

        <?php
        if($id = 1){
            echo"
            <br>
            <label for='funcao'>função:</label>
        <input type='text' name='funcao' value='"; echo $row['funcao_usuario']; echo"' required>
            ";
        } 
        ?>
        <br>
        <input type="submit" value="Atualizar">

    </form>

    <a href="geral.php">VOLTAR AS CONFIGURAÇÕES.</a>

</body>

</html>