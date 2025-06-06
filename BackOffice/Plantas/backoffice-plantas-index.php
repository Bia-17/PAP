<?php
include_once(__DIR__ . '/../../conectar.php');

$sql = "SELECT * FROM plantas ORDER BY Id_Planta DESC";
$result = $con->query($sql);

if (isset($_GET['mensagem']) && $_GET['mensagem'] === 'eliminado'): ?>
    <div class="mensagem-sucesso">🌱 Planta eliminada com sucesso!</div>
<?php endif;

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Plantas - Index</title>
    <link rel="stylesheet" href="/PAP/css/plantas-index.css">
</head>
<body>

    <h1>Index - Plantas</h1>
    <a class="create-btn" href="backoffice-plantas-criar.php">Criar Nova</a>
    <a href="../backoffice-index.php" class="voltar-btn">
        <button type="button">← Voltar ao Backoffice</button>
    </a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Imagem</th>
                <th>Preço (€)</th>
                <th>Stock</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while($planta = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $planta['Id_Planta'] ?></td>
                    <td><?= htmlspecialchars($planta['Nome_Científico']) ?></td>
                    <td><?= htmlspecialchars($planta['Descrição']) ?></td>
                    <td>
                        <?php
                            $imagens = explode(',', $planta['Imagem']);
                            $primeira_imagem = trim($imagens[0]);
                        ?>
                        <img class="planta-img" src="../../<?= htmlspecialchars($primeira_imagem) ?>" alt="">
                    </td>
                    <td><?= $planta['Preço'] ?></td>
                    <td><?= $planta['Stock'] ?></td>
                    <td class="actions">
                        <a href="/PAP/BackOffice/Plantas/backoffice-plantas-editar.php?id=<?= $planta['Id_Planta'] ?>">Editar</a>
                        <a href="backoffice-plantas-detalhes.php?id=<?= $planta['Id_Planta'] ?>">Detalhes</a>
                        <a href="backoffice-plantas-eliminar.php?id=<?= $planta['Id_Planta'] ?>" onclick="return confirm('Tens a certeza que queres eliminar esta planta?')">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</body>
</html>
