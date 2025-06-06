<?php
include_once(__DIR__ . '/../../conectar.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('ID do utilizador não foi fornecido!');
}

$id_cliente = $_GET['id'];

$sql = "UPDATE utilizadores SET Ativo = 0 WHERE Id_Cliente = ?";
$stmt = $con->prepare($sql);

if (!$stmt) {
    die('Erro ao preparar a desativação: ' . $con->error);
}

$stmt->bind_param("i", $id_cliente);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    header("Location: backoffice-utilizadores-index.php?mensagem=desativado");
    exit;
} else {
    echo "Erro ao desativar o utilizador ou utilizador já estava desativado.";
}
?>
