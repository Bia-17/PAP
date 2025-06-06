<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/detalhes_pedido.css">
    <script src="js/menu.js" defer></script>
    <title>Detalhes do Pedido</title>
</head>
<body>
<?php

session_start();

require_once "conectar.php";

$id_pedido = isset($_GET['id']) ? $_GET['id'] : 0;

$stmt = $con->prepare("SELECT * FROM pedidos WHERE Id_Pedido = ?");
$stmt->bind_param("i", $id_pedido);
$stmt->execute();
$result = $stmt->get_result();
$pedido = $result->fetch_assoc();
$stmt->close();

if (!$pedido) {
    echo "Pedido não encontrado.";
    exit();
}
?>
<div class="detalhes-pedido">
    <h2>Detalhes do Pedido</h2>

    <p><strong>Data do Pedido:</strong> <?php echo htmlspecialchars($pedido['Data_Criação']); ?></p>
    <p><strong>Valor Total:</strong> <?php echo htmlspecialchars($pedido['Total']); ?> €</p>
    <p><strong>Status:</strong> <?php echo htmlspecialchars($pedido['Status_p']); ?></p>
    <p><strong>Plantas:</strong> <?php echo htmlspecialchars($pedido['Plantas']); ?></p>

    <a href="pagina.php" class="btn-voltar">Voltar</a>
</div>
</body>