<?php

if(isset($_GET['logout'])){
    unset($_SESSION);
    session_destroy();
    header("Location: login.php");
    exit;
}

?>