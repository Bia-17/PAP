<?php
include_once(__DIR__ . '/../../conectar.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('ID da planta não foi fornecido!');
}

$id_planta = $_GET['id'];

$sql = "
    SELECT p.*, c.Nome
    FROM plantas p
    JOIN categorias c ON p.Id_Categoria = c.Id_Categoria
    WHERE p.Id_Planta = ?
";

$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id_planta);
$stmt->execute();
$result = $stmt->get_result();
$planta = $result->fetch_assoc();

if (!$planta) {
    die('Planta não encontrada!');
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Detalhes da Planta</title>
    <link rel="stylesheet" href="/PAP/css/plantas-detalhes.css">
</head>
<body>

    <div class="detalhes-container">
        <h1>Detalhes da Planta</h1>

        <div class="detalhe"><strong>ID:</strong> <span><?= $planta['Id_Planta'] ?></span></div>
        <div class="detalhe"><strong>Categoria:</strong> <span><?= $planta['Nome'] ?></span></div>
        <div class="detalhe"><strong>Nome Comum:</strong> <span><?= htmlspecialchars($planta['Nome_Comum']) ?></span></div>
        <div class="detalhe"><strong>Nome Científico:</strong> <span><?= htmlspecialchars($planta['Nome_Científico']) ?></span></div>
        <div class="detalhe"><strong>Preço:</strong> <span><?= $planta['Preço'] ?> €</span></div>
        <div class="detalhe"><strong>Stock:</strong> <span><?= $planta['Stock'] ?></span></div>
        <div class="detalhe"><strong>Altura:</strong> <span><?= htmlspecialchars($planta['Altura']) ?></span></div>
        <div class="detalhe"><strong>Diâmetro:</strong> <span><?= htmlspecialchars($planta['Diâmetro']) ?></span></div>
        <div class="detalhe"><strong>Luminosidade:</strong> <span><?= htmlspecialchars($planta['Luminosidade']) ?></span></div>
        <div class="detalhe"><strong>Rega:</strong> <span><?= htmlspecialchars($planta['Rega']) ?></span></div>
        <div class="detalhe"><strong>Clima:</strong> <span><?= htmlspecialchars($planta['Clima']) ?></span></div>
        <div class="detalhe"><strong>Cor:</strong> <span><?= htmlspecialchars($planta['Cor']) ?></span></div>
        <div class="detalhe"><strong>Data de Criação:</strong> <span><?= $planta['data_criação'] ?></span></div>

        <?php
            $imagens = explode(',', $planta['Imagem']);
            $primeira_imagem = trim($imagens[0]);
        ?>
        <img src="../../<?= htmlspecialchars($primeira_imagem) ?>" alt="<?= htmlspecialchars($planta['Nome_Comum']) ?>" class="imagem-planta">

        <a class="voltar" href="backoffice-plantas-index.php">← Voltar à lista</a>
    </div>

</body>
</html>
