<?php

$mysqli = new mysqli("localhost","root","root","tlb_sa");
if($mysqli->connect_errno){
    die("Erro de conexão: " . $mysqli->connect_error);
}

?>