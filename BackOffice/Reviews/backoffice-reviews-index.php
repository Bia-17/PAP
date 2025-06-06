<?php
include_once(__DIR__ . '/../../conectar.php');

$sql = "
    SELECT r.*, u.Nome AS nome_cliente, p.Nome_Científico AS nome_planta
    FROM reviews r
    LEFT JOIN utilizadores u ON r.Id_Cliente = u.Id_Cliente
    LEFT JOIN plantas p ON r.Id_Planta = p.Id_Planta
    ORDER BY r.Data_Criação DESC
";
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Gestão de Reviews</title>
    <link rel="stylesheet" href="/PAP/css/reviews-index.css">
</head>
<body>

    <div class="reviews-container">
        <h1>Gestão de Reviews</h1>

        <?php if (isset($_GET['mensagem']) && $_GET['mensagem'] === 'eliminada'): ?>
            <p class="mensagem-sucesso">Review eliminada com sucesso!</p>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Planta</th>
                    <th>Texto</th>
                    <th>Rating</th>
                    <th>Data de Criação</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($review = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $review['id_review'] ?></td>
                        <td><?= htmlspecialchars($review['nome_cliente'] ?? 'Desconhecido') ?></td>
                        <td><?= htmlspecialchars($review['nome_planta'] ?? 'Desconhecida') ?></td>
                        <td><?= htmlspecialchars(mb_strimwidth($review['review_texto'], 0, 50, "...")) ?></td>
                        <td><?= $review['rating'] ?>/5</td>
                        <td><?= $review['Data_Criação'] ?></td>
                        <td>
                            <a href="backoffice-reviews-detalhes.php?id=<?= $review['id_review'] ?>">Detalhes</a> |
                            <a href="backoffice-reviews-editar.php?id=<?= $review['id_review'] ?>">Editar</a> |
                            <a href="backoffice-reviews-eliminar.php?id=<?= $review['id_review'] ?>" onclick="return confirm('Te, a certeza que quer eliminar esta review?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <a href="../backoffice-index.php" class="voltar-btn">← Voltar ao Painel</a>
    </div>

</body>
</html>
