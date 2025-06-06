<?php
include_once(__DIR__ . '/../../conectar.php');

$sql = "SELECT * FROM blogue_posts";
$result = $con->query($sql);

if (isset($_GET['mensagem']) && $_GET['mensagem'] === 'eliminado'): ?>
    <div class="mensagem-sucesso">📝 Post eliminado com sucesso!</div>
<?php endif;
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Blogue - Index</title>
    <link rel="stylesheet" href="/PAP/css/blogue-index.css">
</head>
<body>

    <h1>Index - Blogue</h1>

    <a class="create-btn" href="backoffice-blogue-criar.php">Criar Novo Post</a>

    <a href="../backoffice-index.php" class="voltar-btn">
        <button type="button">← Voltar ao Backoffice</button>
    </a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Descrição</th>
                <th>Imagem</th>
                <th>Data de Criação</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while($post = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $post['Id_Posts'] ?></td>
                    <td><?= htmlspecialchars($post['Título']) ?></td>
                    <td><?= htmlspecialchars($post['Descrição']) ?></td>
                    <td>
                        <img class="post-img" src="../../<?= htmlspecialchars($post['Imagem']) ?>" alt="Imagem do Post">
                    </td>
                    <td><?= $post['Data_Criação'] ?></td>
                    <td class="actions">
                        <a href="backoffice-blogue-editar.php?id=<?= $post['Id_Posts'] ?>">Editar</a>
                        <a href="backoffice-blogue-detalhes.php?id=<?= $post['Id_Posts'] ?>">Detalhes</a>
                        <a href="backoffice-blogue-eliminar.php?id=<?= $post['Id_Posts'] ?>" onclick="return confirm('Tem a certeza que quer eliminar este post?')">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</body>
</html>
