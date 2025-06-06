<?php
session_start();
require_once "conectar.php";

if (!isset($_SESSION['Email'])) {
    header("Location: conta.php");
    exit();
}

$email = $_SESSION['Email'];
$notificacoes = isset($_POST['notificacoes_email']) ? 1 : 0;

$stmt = $con->prepare("UPDATE utilizadores SET Notificacoes_Email = ? WHERE Email = ?");
$stmt->bind_param("is", $notificacoes, $email);

if ($stmt->execute()) {
    $_SESSION['success_message'] = "Preferências atualizadas com sucesso!";
} else {
    $_SESSION['error_message'] = "Erro ao atualizar as preferências.";
}

$stmt->close();
$con->close();

header("Location: pagina.php");
exit();
?>
