<?php
include_once 'conectar.php';

$termo = isset($_GET['q']) ? trim($_GET['q']) : '';

if (empty($termo)) {
    echo "<p>Por favor, insira um termo para pesquisar.</p>";
    exit;
}

$sql_posts = "SELECT * FROM blogue_posts WHERE Título LIKE '%$termo%' OR Descrição LIKE '%$termo%' OR Conteúdo LIKE '%$termo%'";
$result_posts = mysqli_query($con, $sql_posts);

$sql_plantas = "SELECT * FROM plantas WHERE Nome_Comum LIKE '%$termo%' OR Nome_Científico LIKE '%$termo%' OR Descrição LIKE '%$termo%'";
$result_plantas = mysqli_query($con, $sql_plantas);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Resultados da Pesquisa</title>
    <link rel="stylesheet" href="css/resultados.css">
</head>
<body>
    <div class="container">
        <h1>Resultados da Pesquisa</h1>

        <?php if (mysqli_num_rows($result_posts) > 0): ?>
            <h2>Blogue</h2>
            <?php while ($post = mysqli_fetch_assoc($result_posts)): ?>
                <div class="resultado">
                    <h3><?= htmlspecialchars($post['Título']) ?></h3>
                    <p><?= htmlspecialchars($post['Descrição']) ?></p>
                    <a href="post.php?Id=<?= $post['Id_Posts'] ?>">Ler Mais</a>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>

        <?php if (mysqli_num_rows($result_plantas) > 0): ?>
            <h2>Plantas e Árvores</h2>
            <?php while ($planta = mysqli_fetch_assoc($result_plantas)): ?>
                <div class="resultado">
                    <h3><?= htmlspecialchars($planta['Nome_Comum']) ?> (<?= htmlspecialchars($planta['Nome_Científico']) ?>)</h3>
                    <p><?= htmlspecialchars($planta['Descrição']) ?></p>
                    <p><strong>Preço:</strong> <?= htmlspecialchars($planta['Preço']) ?>€</p>
                    <a class="ver-detalhes" href="planta.php?id=<?php echo $planta['Id_Planta']; ?>">Ver detalhes</a>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>

        <?php if (mysqli_num_rows($result_posts) === 0 && mysqli_num_rows($result_plantas) === 0): ?>
            <p>Nenhum resultado encontrado para "<strong><?= htmlspecialchars($termo) ?></strong>".</p>
        <?php endif; ?>

        <a href="javascript:history.back()" class="voltar-btn">← Voltar</a>
    </div>
</body>

</html>
