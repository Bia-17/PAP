<?php
include_once(__DIR__ . '/../../conectar.php');

$mensagem = '';
if (isset($_GET['mensagem'])) {
    if ($_GET['mensagem'] === 'criada') {
        $mensagem = "Categoria criada com sucesso!";
    } elseif ($_GET['mensagem'] === 'alterada') {
        $mensagem = "Categoria alterada com sucesso!";
    } elseif ($_GET['mensagem'] === 'eliminada') {
        $mensagem = "Categoria eliminada com sucesso!";
    }
}

$sql = "SELECT * FROM categorias ORDER BY Id_Categoria DESC";
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Gestão de Categorias</title>
    <link rel="stylesheet" href="/PAP/css/categorias-index.css">
</head>
<body>

    <h1>Gestão de Categorias</h1>

    <?php if (!empty($mensagem)): ?>
        <div class="mensagem-sucesso"><?= htmlspecialchars($mensagem) ?></div>
    <?php endif; ?>

    <a href="backoffice-categorias-criar.php" class="create-btn">+ Criar Nova Categoria</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($categoria = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $categoria['Id_Categoria'] ?></td>
                    <td><?= htmlspecialchars($categoria['Nome']) ?></td>
                    <td><?= htmlspecialchars($categoria['Descrição']) ?></td>
                    <td class="actions">
                        <a href="backoffice-categorias-editar.php?id=<?= $categoria['Id_Categoria'] ?>">Alterar</a>
                        <a href="backoffice-categorias-eliminar.php?id=<?= $categoria['Id_Categoria'] ?>" onclick="return confirm('Tem a certeza que deseja eliminar esta categoria?')">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <div class="voltar-btn">
        <a href="../backoffice-index.php"><button type="button">← Voltar ao Backoffice</button></a>
    </div>

</body>
</html>
