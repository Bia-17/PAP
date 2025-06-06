<?php
include_once(__DIR__ . '/../../conectar.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID da review não foi fornecido.");
}

$id_review = $_GET['id'];

$sql = "DELETE FROM reviews WHERE id_review = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id_review);

if ($stmt->execute()) {
    header("Location: backoffice-reviews-index.php?mensagem=eliminada");
    exit();
} else {
    die("Erro ao eliminar a review: " . $stmt->error);
}
?>
