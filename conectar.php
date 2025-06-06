<?php
$servidor = "localhost"; 
$user = "root"; 
$pass = ""; 
$bd = "pap"; 
$con = new mysqli($servidor,$user,$pass,$bd); 
if ($con->connect_errno) {
    echo "Falha na ligação: " . $con->connect_error; 
    exit();
}
?>