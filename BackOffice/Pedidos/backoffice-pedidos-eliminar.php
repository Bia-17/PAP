<?php
include_once(__DIR__ . '/../../conectar.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('ID do pedido não foi fornecido!');
}

$id_pedido = $_GET['id'];

$sql = "SELECT * FROM pedidos WHERE Id_Pedido = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id_pedido);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die('Pedido não encontrado!');
}

// Elimina o pedido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql_delete = "DELETE FROM pedidos WHERE Id_Pedido = ?";
    $stmt_delete = $con->prepare($sql_delete);
    $stmt_delete->bind_param("i", $id_pedido);
    $stmt_delete->execute();

    header('Location: backoffice-pedidos-index.php?mensagem=eliminado');
    exit;
}

$pedido = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Pedido</title>
    <link rel="stylesheet" href="/PAP/css/pedidos-eliminar.css">
</head>
<body>

    <div class="eliminar-container">
        <h1>Eliminar Pedido</h1>

        <p>Tem a certeza que deseja eliminar o pedido <strong>#<?= $pedido['Id_Pedido'] ?></strong>?</p>
        
        <form action="backoffice-pedidos-eliminar.php?id=<?= $pedido['Id_Pedido'] ?>" method="POST">
            <button type="submit" class="confirmar-btn">Sim, eliminar</button>
            <a href="backoffice-pedidos-index.php" class="cancelar-btn">Cancelar</a>
        </form>
    </div>

</body>
</html>
