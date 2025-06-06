<?php
session_start();

include_once(__DIR__ . '/../conectar.php');

if (!isset($_SESSION['Id_Cliente'])) {
    header("Location: /PAP/conta.php");
    exit();
}

$usuario_id = $_SESSION['Id_Cliente'];

$sql = "SELECT cargos FROM utilizadores WHERE Id_Cliente = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

if ($usuario['cargos'] !== 'admin') {
    header("Location: /PAP/conta.php");
    exit();
}
?>
