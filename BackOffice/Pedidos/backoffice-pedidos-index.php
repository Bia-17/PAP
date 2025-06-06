<?php
include_once(__DIR__ . '/../../conectar.php');

$sql = "SELECT * FROM pedidos";
$result = $con->query($sql);

if (isset($_GET['mensagem']) && $_GET['mensagem'] === 'eliminado'): ?>
    <div class="mensagem-sucesso">📦 Pedido eliminado com sucesso!</div>
<?php endif;
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Pedidos - Index</title>
    <link rel="stylesheet" href="/PAP/css/pedidos-index.css">
</head>
<body>

    <h1>Index - Pedidos</h1>
    <a class="create-btn" href="backoffice-pedidos-criar.php">Criar Novo Pedido</a>
    <a href="../backoffice-index.php" class="voltar-btn">← Voltar ao Backoffice</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Status</th>
                <th>Total (€)</th>
                <th>Data de Criação</th>
                <th>Data de Atualização</th>
                <th>Plantas</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while($pedido = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $pedido['Id_Pedido'] ?></td>
                    <td><?= $pedido['Id_Cliente'] ?></td>
                    <td><?= htmlspecialchars($pedido['Status_p']) ?></td>
                    <td><?= number_format($pedido['Total'], 2) ?></td>
                    <td><?= $pedido['Data_Criação'] ?></td>
                    <td><?= $pedido['Data_Atualização'] ?></td>
                    <td><?= htmlspecialchars($pedido['Plantas']) ?></td>
                    <td class="actions">
                        <a href="backoffice-pedidos-detalhes.php?id=<?= $pedido['Id_Pedido'] ?>">Detalhes</a>
                        <a href="backoffice-pedidos-editar.php?id=<?= $pedido['Id_Pedido'] ?>">Editar</a>
                        <a href="backoffice-pedidos-eliminar.php?id=<?= $pedido['Id_Pedido'] ?>" onclick="return confirm('Tem a certeza que quer eliminar este pedido?')">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</body>
</html>
