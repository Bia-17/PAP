<?php
include("conectar.php");
$query="SELECT * FROM plantas WHERE Id_Categoria IN (1, 2, 6, 8, 9) ORDER BY Id_Planta DESC";
$r=mysqli_query($con,$query);
?>