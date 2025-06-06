<?php
include_once(__DIR__ . '/../../conectar.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Receber os dados do formulário
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

    // Inserir na base de dados
    $sql = "INSERT INTO plantas (Id_Categoria, Nome_Comum, Nome_Científico, Descrição, Preço, Stock, Imagem, Altura, Diâmetro, Luminosidade, Rega, Clima, Cor) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $con->prepare($sql);
    $stmt->bind_param("isssdisssssss", $id_categoria, $nome_comum, $nome_cientifico, $descricao, $preco, $stock, $imagem, $altura, $diametro, $luminosidade, $rega, $clima, $cor);

    if ($stmt->execute()) {
        header("Location: backoffice-plantas-index.php?mensagem=criado");
        exit();
    } else {
        $error_message = "Erro ao criar a planta!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Criar Nova Planta</title>
    <link rel="stylesheet" href="/PAP/css/plantas-criar.css">
</head>
<body>

    <div class="form-container">
        <h1>Criar Nova Planta</h1>

        <?php if (isset($error_message)): ?>
            <div class="error"><?= htmlspecialchars($error_message) ?></div>
        <?php endif; ?>

        <form action="backoffice-plantas-criar.php" method="POST">
            <!-- Categoria -->
            <label for="id_categoria">Categoria:</label>
            <select id="id_categoria" name="id_categoria" required>
                <option value="">Escolher Categoria</option>
                <option value="1">Suculentas</option>
                <option value="2">Cactos</option>
                <option value="3">Árvores de Fruto</option>
                <option value="4">Árvores de Flor</option>
                <option value="5">Arbustos Frutíferos</option>
                <option value="6">Plantas Aromáticas</option>
                <option value="7">Trepadeiras</option>
                <option value="8">Plantas de Interior</option>
                <option value="9">Plantas Ornamentais</option>
                <option value="10">Cactos Frutíferos</option>
                <option value="11">Trepadeira Frutífera</option>
                <option value="12">Árvore Ornamental</option>
                <option value="13">Arbustos Ornamentais</option>
            </select>

            <!-- Nome Comum -->
            <label for="nome_comum">Nome Comum:</label>
            <input type="text" id="nome_comum" name="nome_comum" required>

            <!-- Nome Científico -->
            <label for="nome_cientifico">Nome Científico:</label>
            <input type="text" id="nome_cientifico" name="nome_cientifico" required>

            <!-- Descrição -->
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" required></textarea>

            <!-- Preço -->
            <label for="preco">Preço (€):</label>
            <input type="number" step="0.01" id="preco" name="preco" required>

            <!-- Stock -->
            <label for="stock">Stock:</label>
            <input type="number" id="stock" name="stock" required>

            <!-- Imagem -->
            <label for="imagem">Imagem:</label>
            <input type="text" id="imagem" name="imagem" required>

            <!-- Altura -->
            <label for="altura">Altura:</label>
            <input type="text" id="altura" name="altura" required>

            <!-- Diâmetro -->
            <label for="diametro">Diâmetro:</label>
            <input type="text" id="diametro" name="diametro" required>

            <!-- Luminosidade -->
            <label for="luminosidade">Luminosidade:</label>
            <textarea id="luminosidade" name="luminosidade" required></textarea>

            <!-- Rega -->
            <label for="rega">Rega:</label>
            <textarea id="rega" name="rega" required></textarea>

            <!-- Clima -->
            <label for="clima">Clima:</label>
            <textarea id="clima" name="clima" required></textarea>

            <!-- Cor -->
            <label for="cor">Cor:</label>
            <input type="text" id="cor" name="cor" required>

            <button type="submit">Criar Planta</button>
        </form>

        <a class="voltar" href="backoffice-plantas-index.php">← Voltar à lista</a>
    </div>

</body>
</html>
