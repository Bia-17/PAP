<?php
include_once(__DIR__ . '/../../conectar.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('ID do post não foi fornecido!');
}

$id_post = $_GET['id'];

$sql = "SELECT p.*, c.Nome
        FROM blogue_posts p
        JOIN blogue_categorias c ON p.Id_BCat = c.Id_BCat
        WHERE p.Id_Posts = ?";
$stmt = $con->prepare($sql);

if (!$stmt) {
    die("Erro ao preparar a consulta: " . $con->error);
}

$stmt->bind_param("i", $id_post);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

if (!$post) {
    die('Post não encontrado!');
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Post</title>
    <link rel="stylesheet" href="/PAP/css/blogue-detalhes.css">
</head>
<body>

<div class="detalhes-container">
    <h1><?= htmlspecialchars($post['Título']) ?></h1>

    <img class="imagem-post" src="/PAP/<?= htmlspecialchars($post['Imagem']) ?>" alt="Imagem do Post">

    <div class="info">
        <p><strong>ID:</strong> <?= $post['Id_Posts'] ?></p>
        <p><strong>Categoria:</strong> <?= $post['Nome'] ?></p>
        <p><strong>Descrição:</strong> <?= nl2br(htmlspecialchars($post['Descrição'])) ?></p>
        <p><strong>Conteúdo:</strong> <?= nl2br(htmlspecialchars($post['Conteúdo'])) ?></p>
        <p><strong>Conclusão:</strong> <?= nl2br(htmlspecialchars($post['Conclusão'])) ?></p>
        <p><strong>Data de Criação:</strong> <?= $post['Data_Criação'] ?></p>
        <p><strong>Data de Atualização:</strong> <?= $post['Data_Atualização'] ?></p>
    </div>

    <a class="voltar-btn" href="backoffice-blogue-index.php">← Voltar à lista de posts</a>
</div>

</body>
</html>
