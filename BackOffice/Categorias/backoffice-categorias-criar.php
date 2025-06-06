<?php
include_once(__DIR__ . '/../../conectar.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];

    if (!empty($nome) && !empty($descricao)) {
        $sql = "INSERT INTO categorias (Nome, Descrição) VALUES (?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ss", $nome, $descricao);
        $stmt->execute();

        header("Location: backoffice-categorias-index.php?mensagem=criada");
        exit();
    } else {
        $erro = "Preenche todos os campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Criar Categoria</title>
    <link rel="stylesheet" href="/PAP/css/categorias-criar.css">
</head>
<body>

    <div class="criar-container">
        <h1>Criar Nova Categoria</h1>

        <?php if (isset($erro)): ?>
            <p class="erro"><?= $erro ?></p>
        <?php endif; ?>

        <form method="POST">
            <label for="nome">Nome da Categoria:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" rows="4" required></textarea>

            <button type="submit">Criar Categoria</button>
        </form>

        <a href="backoffice-categorias-index.php" class="voltar-btn">← Voltar</a>
    </div>

</body>
</html>
