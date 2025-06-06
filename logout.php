<?php
session_start();
session_unset();
session_destroy();
session_start();
$_SESSION['msg_sucesso'] = "Sessão terminada com sucesso.";
header("location: paginicial.php");
exit();
?>