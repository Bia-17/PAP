<?php
include_once(__DIR__ . '/../../conectar.php');

// Obter todas as categorias
$sql = "SELECT * FROM blogue_categorias";
$result = $con->query($sql);

if (isset($_GET['mensagem']) && $_GET['mensagem'] === 'criada'): ?>
    <div class="mensagem-sucesso">✔ Categoria criada com sucesso!</div>
<?php endif;

if (isset($_GET['mensagem']) && $_GET['mensagem'] === 'eliminada'): ?>
    <div class="mensagem-sucesso">✔ Categoria eliminada com sucesso!</div>
<?php endif;
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Categorias - Blogue</title>
    <link rel="stylesheet" href="/PAP/css/blogue-categorias-index.css">
</head>
<body>

    <h1>Gerir Categorias do Blogue</h1>

    <a href="backoffice-blogue-categorias-criar.php" class="create-btn">Criar Nova Categoria</a>
    <a href="../backoffice-index.php" class="voltar-btn">← Voltar ao Backoffice</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome da Categoria</th>
                <th>Descrição</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($categoria = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $categoria['Id_BCat'] ?></td>
                    <td><?= htmlspecialchars($categoria['Nome']) ?></td>
                    <td><?= htmlspecialchars($categoria['Descrição']) ?></td>
                    <td class="actions">
                        <a href="backoffice-blogue-categorias-editar.php?id=<?= $categoria['Id_BCat'] ?>">Editar</a>
                        <a href="backoffice-blogue-categorias-eliminar.php?id=<?= $categoria['Id_BCat'] ?>" onclick="return confirm('Tem a certeza que quer eliminar esta categoria?')">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</body>
</html>