<?php
include_once(__DIR__ . '/../../conectar.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('ID do utilizador não foi fornecido!');
}

$id_utilizador = $_GET['id'];

$sql = "SELECT * FROM utilizadores WHERE Id_Cliente = ?";
$stmt = $con->prepare($sql);

if (!$stmt) {
    die("Erro ao preparar a consulta: " . $con->error);
}

$stmt->bind_param("i", $id_utilizador);
$stmt->execute();
$result = $stmt->get_result();
$utilizador = $result->fetch_assoc();

if (!$utilizador) {
    die('Utilizador não encontrado!');
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Utilizador</title>
    <link rel="stylesheet" href="/PAP/css/blogue-detalhes.css">
</head>
<body>

<div class="detalhes-container">
    <h1><?= htmlspecialchars($utilizador['Nome']) ?></h1>

    <div class="info">
        <p><strong>ID:</strong> <?= $utilizador['Id_Cliente'] ?></p>
        <p><strong>Nome:</strong> <?= htmlspecialchars($utilizador['Nome']) ?></p>
        <p><strong>Telemóvel:</strong> <?= htmlspecialchars($utilizador['Telemóvel']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($utilizador['Email']) ?></p>
        <p><strong>Morada:</strong> <?= htmlspecialchars($utilizador['Morada']) ?></p>
        <p><strong>Data de Criação:</strong> <?= $utilizador['Data_Criação'] ?></p>
        <p><strong>Cargo:</strong> <?= htmlspecialchars($utilizador['cargos']) ?></p>
        <p><strong>Notificações por Email:</strong> <?= $utilizador['Notificacoes_Email'] ? 'Sim' : 'Não' ?></p>
        <p><strong>Estado:</strong> <?= $utilizador['Ativo'] ? 'Ativo' : 'Desativado' ?></p>
    </div>

    <a class="voltar-btn" href="backoffice-utilizadores-index.php">← Voltar à lista de utilizadores</a>
</div>

</body>
</html>
