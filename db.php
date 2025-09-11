<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "TLB_SA";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexao falhou: " . $conn->connect_error);
}