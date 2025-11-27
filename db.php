<?php

<<<<<<< HEAD
$conn = new mysqli("localhost","root","","tlb_sa");
=======
$conn = new mysqli("localhost","","","tlb_sa");
>>>>>>> e938ae9159a06688e002ab0b85d5e65d4288e942
if($conn->connect_errno){
    die("Erro de conexão: " . $conn->connect_error);
}

?>