<?php
include_once(__DIR__ . '/../../conectar.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('ID do pedido não foi fornecido!');
}

$id_pedido = $_GET['id'];

$sql = "
    SELECT p.*, u.Nome AS Nome_Cliente, u.Morada, u.Telemóvel, u.Email
    FROM pedidos p
    JOIN utilizadores u ON p.Id_Cliente = u.Id_Cliente
    WHERE p.Id_Pedido = ?
";
$stmt = $con->prepare($sql);

// Verificar se a preparação da consulta foi bem-sucedida
if (!$stmt) {
    die('Erro ao preparar a consulta: ' . $con->error);
}

// Vincular o parâmetro
$stmt->bind_param("i", $id_pedido);

// Executar a consulta
$stmt->execute();

// Obter o resultado
$result = $stmt->get_result();

// Verificar se o pedido foi encontrado
$pedido = $result->fetch_assoc();
if (!$pedido) {
    die('Pedido não encontrado!');
}

$nomes_plantas = explode(',', $pedido['Plantas']);

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Pedido</title>
    <link rel="stylesheet" href="/PAP/css/pedidos-detalhes.css">
    <script>
        function imprimir() {
            window.print();
        }
    </script>
</head>
<body>

    <div class="detalhes-container">
        <h1>Detalhes do Pedido</h1>

        <div class="detalhe"><strong>ID do Pedido:</strong> <?= $pedido['Id_Pedido'] ?></div>
        <div class="detalhe"><strong>Nome do Cliente:</strong> <?= htmlspecialchars($pedido['Nome_Cliente']) ?></div>
        <div class="detalhe"><strong>Morada:</strong> <?= htmlspecialchars($pedido['Morada']) ?></div>
        <div class="detalhe"><strong>Número de Telemóvel:</strong> <?= htmlspecialchars($pedido['Telemóvel']) ?></div>
        <div class="detalhe"><strong>Email:</strong> <?= htmlspecialchars($pedido['Email']) ?></div>
        <div class="detalhe"><strong>Status:</strong> <?= htmlspecialchars($pedido['Status_p']) ?></div>
        <div class="detalhe"><strong>Total:</strong> <?= $pedido['Total'] ?> €</div>
        <div class="detalhe"><strong>Data de Criação:</strong> <?= $pedido['Data_Criação'] ?></div>
        <div class="detalhe"><strong>Data de Atualização:</strong> <?= $pedido['Data_Atualização'] ?></div>

        <h2>Plantas Pedidas</h2>
        <ul>
            <?php foreach ($nomes_plantas as $planta): ?>
                <li><?= htmlspecialchars(trim($planta)) ?></li>
            <?php endforeach; ?>
        </ul>

        <a class="voltar-btn" href="backoffice-pedidos-index.php">← Voltar à lista de pedidos</a>
        <button class="imprimir-btn" onclick="imprimir()">Imprimir Detalhes do Pedido</button>
    </div>

</body>
</html>
