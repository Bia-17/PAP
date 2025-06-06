<?php
include_once(__DIR__ . '/../../conectar.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('ID da planta não foi fornecido!');
}

$id_planta = $_GET['id'];

$sql_verifica = "SELECT * FROM plantas WHERE Id_Planta = ?";
$stmt_verifica = $con->prepare($sql_verifica);
$stmt_verifica->bind_param("i", $id_planta);
$stmt_verifica->execute();
$result = $stmt_verifica->get_result();

if ($result->num_rows === 0) {
    die('Planta não encontrada!');
}

// Eliminar planta
$sql_eliminar = "DELETE FROM plantas WHERE Id_Planta = ?";
$stmt = $con->prepare($sql_eliminar);
$stmt->bind_param("i", $id_planta);

if ($stmt->execute()) {
    header("Location: backoffice-plantas-index.php?mensagem=eliminado");
    exit();
} else {
    echo "Erro ao eliminar a planta.";
}
?>
