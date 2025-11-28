<?php


include '../db.php';
session_start();

$user = $_SESSION['id_usuario'];

$sql = "SELECT * FROM usuario";
$result = $conn->query($sql);
echo"
<table border = '1'>
<tr>
<th>   ID   </th>
<th>  nome  </th>
<th>  senha </th>
<th>telefone</th>
<th>  email </th>
<th> função </th>
<th>alterações</th>
</tr>
";
while($row = $result->fetch_assoc()){
    echo"
    <tr>
    <td>
    {$row['id_usuario']}
    </td>
    <td>
    {$row['nome_usuario']}
    </td>
    <td>{$row['senha_usuario']}</td>
    <td>{$row['telefone_usuario']}</td>
    <td>{$row['email_usuario']}</td>
    <td>{$row['funcao_usuario']}</td>
    "; if($id = 1){
            echo"
    <td><a href = 'alterar.php'> Alterar</a></td>";
    echo"
    </tr>

    ";
}};
?>

