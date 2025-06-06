<?php
include_once(__DIR__ . '/../../conectar.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cliente = $_POST['id_cliente'];
    $status_p = $_POST['status_p'];
    $total = $_POST['total'];
    $data_criacao = $_POST['data_criacao'];
    $data_atualizacao = $_POST['data_atualizacao'];

    $sql = "INSERT INTO pedidos (Id_Cliente, Status_p, Total, Data_Criação, Data_Atualização) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("issss", $id_cliente, $status_p, $total, $data_criacao, $data_atualizacao);
    $stmt->execute();

    header('Location: backoffice-pedidos-index.php?mensagem=criado');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Criar Pedido</title>
    <link rel="stylesheet" href="/PAP/css/pedidos-criar.css">
</head>
<body>

    <div class="criar-container">
        <h1>Criar Novo Pedido</h1>

        <form action="backoffice-pedidos-criar.php" method="POST">
            <label for="id_cliente">ID do Cliente</label>
            <input type="number" id="id_cliente" name="id_cliente" required>

            <label for="status_p">Status do Pedido</label>
            <select id="status_p" name="status_p" required>
                <option value="Pendente">Pendente</option>
                <option value="Em Processamento">Em Processamento</option>
                <option value="Concluído">Concluído</option>
            </select>


            <label for="total">Total (€)</label>
            <input type="number" id="total" name="total" required>

            <label for="data_criacao">Data de Criação</label>
            <input type="date" id="data_criacao" name="data_criacao" required>

            <label for="data_atualizacao">Data de Atualização</label>
            <input type="date" id="data_atualizacao" name="data_atualizacao" required>

            <button type="submit">Criar Pedido</button>
        </form>

        <a href="backoffice-pedidos-index.php" class="cancelar-btn">Cancelar</a>
    </div>

</body>
</html>
