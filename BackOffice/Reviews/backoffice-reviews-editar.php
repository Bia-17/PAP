<?php
include_once(__DIR__ . '/../../conectar.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID da review não foi fornecido.");
}

$id_review = $_GET['id'];

$sql = "SELECT * FROM reviews WHERE id_review = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id_review);
$stmt->execute();
$result = $stmt->get_result();
$review = $result->fetch_assoc();

if (!$review) {
    die("Review não encontrada.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $review_texto = $_POST['review_texto'];
    $rating = $_POST['rating'];

    $update_sql = "UPDATE reviews SET review_texto = ?, rating = ? WHERE id_review = ?";
    $update_stmt = $con->prepare($update_sql);
    $update_stmt->bind_param("sii", $review_texto, $rating, $id_review);

    if ($update_stmt->execute()) {
        header("Location: backoffice-reviews-index.php?mensagem=atualizada");
        exit();
    } else {
        echo "Erro ao atualizar a review.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Review</title>
    <link rel="stylesheet" href="/PAP/css/reviews-editar.css">
</head>
<body>

<div class="editar-container">
    <h1>Editar Review</h1>

    <form action="" method="POST">
        <label for="review_texto">Texto da Review:</label>
        <textarea id="review_texto" name="review_texto" rows="4" required><?= htmlspecialchars($review['review_texto']) ?></textarea>

        <label for="rating">Classificação (1 a 5):</label>
        <select id="rating" name="rating" required>
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <option value="<?= $i ?>" <?= $i == $review['rating'] ? 'selected' : '' ?>><?= $i ?></option>
            <?php endfor; ?>
        </select>

        <button type="submit">Atualizar Review</button>
    </form>

    <a href="backoffice-reviews-index.php" class="voltar-btn">← Voltar às Reviews</a>
</div>

</body>
</html>
