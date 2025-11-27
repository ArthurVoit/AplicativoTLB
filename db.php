<?php

$conn = new mysqli("localhost","root","","tlb_sa");
if($conn->connect_errno){
    die("Erro de conexão: " . $conn->connect_error);
}

?>