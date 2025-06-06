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

$pedido = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cliente = $_POST['id_cliente'];
    $status_p = $_POST['status_p'];
    $total = $_POST['total'];
    $data_criacao = $_POST['data_criacao'];
    $data_atualizacao = $_POST['data_atualizacao'];

    $sql_update = "UPDATE pedidos 
                   SET Id_Cliente = ?, Status_p = ?, Total = ?, Data_Criação = ?, Data_Atualização = ? 
                   WHERE Id_Pedido = ?";
    $stmt_update = $con->prepare($sql_update);
    $stmt_update->bind_param("issssi", $id_cliente, $status_p, $total, $data_criacao, $data_atualizacao, $id_pedido);
    $stmt_update->execute();

    header('Location: backoffice-pedidos-index.php?mensagem=editado');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Pedido</title>
    <link rel="stylesheet" href="/PAP/css/pedidos-editar.css">
</head>
<body>

    <div class="editar-container">
        <h1>Editar Pedido</h1>

        <form action="backoffice-pedidos-editar.php?id=<?= $pedido['Id_Pedido'] ?>" method="POST">
            <label for="id_cliente">ID do Cliente</label>
            <input type="number" id="id_cliente" name="id_cliente" value="<?= $pedido['Id_Cliente'] ?>" required>

            <label for="status_p">Status do Pedido</label>
            <select id="status_p" name="status_p" required>
                <option value="Pendente" <?= $pedido['Status_p'] === 'Pendente' ? 'selected' : '' ?>>Pendente</option>
                <option value="Em Processamento" <?= $pedido['Status_p'] === 'Em Processamento' ? 'selected' : '' ?>>Em Processamento</option>
                <option value="Concluído" <?= $pedido['Status_p'] === 'Concluído' ? 'selected' : '' ?>>Concluído</option>
            </select>


            <label for="total">Total (€)</label>
            <input type="number" id="total" name="total" value="<?= $pedido['Total'] ?>" required>

            <label for="data_criacao">Data de Criação</label>
            <input type="date" id="data_criacao" name="data_criacao" value="<?= $pedido['Data_Criação'] ?>" required>

            <label for="data_atualizacao">Data de Atualização</label>
            <input type="date" id="data_atualizacao" name="data_atualizacao" value="<?= $pedido['Data_Atualização'] ?>" required>

            <button type="submit">Editar Pedido</button>
        </form>

        <a href="backoffice-pedidos-index.php" class="cancelar-btn">Cancelar</a>
    </div>

</body>
</html>
