<?php
session_start();

include("conectar.php");

if(!isset($_SESSION['Email']) || $_SESSION['cargos'] !== 'admin'){
    header("Location: login.php");
    exit();
}

