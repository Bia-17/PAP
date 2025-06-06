<?php
include_once(__DIR__ . '/../../conectar.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('ID da planta não foi fornecido!');
}

$id_planta = $_GET['id'];

$sql = "SELECT * FROM plantas WHERE Id_Planta = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id_planta);
$stmt->execute();
$result = $stmt->get_result();
$planta = $result->fetch_assoc();

if (!$planta) {
    die('Planta não encontrada!');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_categoria = $_POST['id_categoria'];
    $nome_comum = $_POST['nome_comum'];
    $nome_cientifico = $_POST['nome_cientifico'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $stock = $_POST['stock'];
    $imagem = $_POST['imagem'];
    $altura = $_POST['altura'];
    $diametro = $_POST['diametro'];
    $luminosidade = $_POST['luminosidade'];
    $rega = $_POST['rega'];
    $clima = $_POST['clima'];
    $cor = $_POST['cor'];

    $update_sql = "UPDATE plantas SET Id_Categoria = ?, Nome_Comum = ?, Nome_Científico = ?, Descrição = ?, Preço = ?, Stock = ?, Imagem = ?, Altura = ?, Diâmetro = ?, Luminosidade = ?, Rega = ?, Clima = ?, Cor = ? WHERE Id_Planta = ?";
    $update_stmt = $con->prepare($update_sql);
    $update_stmt->bind_param("isssdisssssssi", $id_categoria, $nome_comum, $nome_cientifico, $descricao, $preco, $stock, $imagem, $altura, $diametro, $luminosidade, $rega, $clima, $cor, $id_planta);
    
    if ($update_stmt->execute()) {
        header("Location: backoffice-plantas-editar.php?id=$id_planta&success=1");
        exit();
    } else {
        $error_message = "Erro ao atualizar a planta!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Planta - Backoffice</title>
    <link rel="stylesheet" href="/PAP/css/plantas-editar.css">
</head>
<body>
    <h1>Editar Planta</h1>

    <?php if (isset($error_message)): ?>
        <div class="error"><?= htmlspecialchars($error_message) ?></div>
    <?php elseif (isset($_GET['success'])): ?>
        <div class="success">Planta atualizada com sucesso!</div>
    <?php endif; ?>
    <div class="container">
        <form action="backoffice-plantas-editar.php?id=<?= $id_planta ?>" method="POST">
            <label for="id_planta">ID da Planta:</label>
            <input type="text" id="id_planta" name="id_planta" value="<?= $planta['Id_Planta'] ?>" disabled>

            <!-- Categoria -->
            <label for="id_categoria">Categoria:</label>
            <select id="id_categoria" name="id_categoria" required>
                <option value="">Escolher Categoria</option>
                <option value="1" <?= ($planta['Id_Categoria'] == 1) ? 'selected' : '' ?>>Suculentas</option>
                <option value="2" <?= ($planta['Id_Categoria'] == 2) ? 'selected' : '' ?>>Cactos</option>
                <option value="3" <?= ($planta['Id_Categoria'] == 3) ? 'selected' : '' ?>>Árvores de Fruto</option>
                <option value="4" <?= ($planta['Id_Categoria'] == 4) ? 'selected' : '' ?>>Árvores de Flor</option>
                <option value="5" <?= ($planta['Id_Categoria'] == 5) ? 'selected' : '' ?>>Arbustos Frutíferos</option>
                <option value="6" <?= ($planta['Id_Categoria'] == 6) ? 'selected' : '' ?>>Plantas Aromáticas</option>
                <option value="7" <?= ($planta['Id_Categoria'] == 7) ? 'selected' : '' ?>>Trepadeiras</option>
                <option value="8" <?= ($planta['Id_Categoria'] == 8) ? 'selected' : '' ?>>Plantas de Interior</option>
                <option value="9" <?= ($planta['Id_Categoria'] == 9) ? 'selected' : '' ?>>Plantas Ornamentais</option>
                <option value="10" <?= ($planta['Id_Categoria'] == 10) ? 'selected' : '' ?>>Cactos Frutíferos</option>
                <option value="11" <?= ($planta['Id_Categoria'] == 11) ? 'selected' : '' ?>>Trepadeira Frutífera</option>
                <option value="12" <?= ($planta['Id_Categoria'] == 12) ? 'selected' : '' ?>>Árvore Ornamental</option>
                <option value="13" <?= ($planta['Id_Categoria'] == 13) ? 'selected' : '' ?>>Arbustos Ornamentais</option>
            </select>

            <!-- Nome Comum -->
            <label for="nome_comum">Nome Comum:</label>
            <input type="text" id="nome_comum" name="nome_comum" value="<?= htmlspecialchars($planta['Nome_Comum']) ?>" required>

            <!-- Nome Científico -->
            <label for="nome_cientifico">Nome Científico:</label>
            <input type="text" id="nome_cientifico" name="nome_cientifico" value="<?= htmlspecialchars($planta['Nome_Científico']) ?>" required>

            <!-- Descrição -->
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" required><?= htmlspecialchars($planta['Descrição']) ?></textarea>

            <!-- Preço -->
            <label for="preco">Preço (€):</label>
            <input type="number" step="0.01" id="preco" name="preco" value="<?= htmlspecialchars($planta['Preço']) ?>" required>

            <!-- Stock -->
            <label for="stock">Stock:</label>
            <input type="number" id="stock" name="stock" value="<?= htmlspecialchars($planta['Stock']) ?>" required>

            <!-- Imagem -->
            <label for="imagem">Imagem:</label>
            <input type="text" id="imagem" name="imagem" value="<?= htmlspecialchars($planta['Imagem']) ?>" required>

            <!-- Altura -->
            <label for="altura">Altura:</label>
            <input type="text" id="altura" name="altura" value="<?= htmlspecialchars($planta['Altura']) ?>" required>

            <!-- Diâmetro -->
            <label for="diametro">Diâmetro:</label>
            <input type="text" id="diametro" name="diametro" value="<?= htmlspecialchars($planta['Diâmetro']) ?>" required>

            <!-- Luminosidade -->
            <label for="luminosidade">Luminosidade:</label>
            <textarea id="luminosidade" name="luminosidade" required><?= htmlspecialchars($planta['Luminosidade']) ?></textarea>

            <!-- Rega -->
            <label for="rega">Rega:</label>
            <textarea id="rega" name="rega" required><?= htmlspecialchars($planta['Rega']) ?></textarea>

            <!-- Clima -->
            <label for="clima">Clima:</label>
            <textarea id="clima" name="clima" required><?= htmlspecialchars($planta['Clima']) ?></textarea>

            <!-- Cor -->
            <label for="clima">Cor:</label>
            <input type="text" id="cor" name="cor" value="<?= htmlspecialchars($planta['Cor']) ?>" required>

            <button type="submit">Atualizar Planta</button>
        </form>
    </div>
        <a href="/PAP/BackOffice/Plantas/backoffice-plantas-index.php">Voltar para a lista de plantas</a>
</body>
</html>
