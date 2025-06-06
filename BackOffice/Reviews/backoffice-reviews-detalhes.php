<?php
include_once(__DIR__ . '/../../conectar.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('ID da review não foi fornecido!');
}

$id_review = $_GET['id'];

$sql = "SELECT r.*, c.Nome AS Nome_Cliente, p.Nome_Científico AS Nome_Científico FROM reviews r
        JOIN utilizadores c ON r.Id_Cliente = c.Id_Cliente
        JOIN plantas p ON r.Id_Planta = p.Id_Planta
        WHERE r.id_review = ?";
        $stmt = $con->prepare($sql);
if (!$stmt) {
    die("Erro no prepare: " . $con->error);
}
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id_review);
$stmt->execute();
$result = $stmt->get_result();
$review = $result->fetch_assoc();

if (!$review) {
    die('Review não encontrada!');
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Detalhes da Review</title>
    <link rel="stylesheet" href="/PAP/css/reviews-detalhes.css">
</head>
<body>

    <div class="detalhes-container">
        <h1>Detalhes da Review</h1>

        <div class="detalhe"><strong>ID da Review:</strong> <?= $review['id_review'] ?></div>
        <div class="detalhe"><strong>Cliente:</strong> <?= htmlspecialchars($review['Nome_Cliente']) ?></div>
        <div class="detalhe"><strong>Planta:</strong> <?= htmlspecialchars($review['Nome_Científico']) ?></div>
        <div class="detalhe"><strong>Texto da Review:</strong> <?= nl2br(htmlspecialchars($review['review_texto'])) ?></div>
        <div class="detalhe"><strong>Classificação:</strong> <?= $review['rating'] ?> / 5</div>
        <div class="detalhe"><strong>Data de Criação:</strong> <?= $review['Data_Criação'] ?></div>

        <a class="voltar-btn" href="backoffice-reviews-index.php">← Voltar às Reviews</a>
    </div>

</body>
</html>
