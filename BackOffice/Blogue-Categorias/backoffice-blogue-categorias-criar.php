<?php
include_once(__DIR__ . '/../../conectar.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];

    $insert_sql = "INSERT INTO blogue_categorias (Nome, Descrição) VALUES (?, ?)";
    $insert_stmt = $con->prepare($insert_sql);
    $insert_stmt->bind_param("ss", $nome, $descricao);
    $insert_stmt->execute();

    header("Location: backoffice-blogue-categorias-index.php?mensagem=criada");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Criar Nova Categoria - Blogue</title>
    <link rel="stylesheet" href="/PAP/css/blogue-categorias-editar.css">
</head>
<body>

    <div class="editar-container">
        <h1>Criar Nova Categoria</h1>

        <form action="" method="POST">
            <div class="form-group">
                <label for="nome">Nome da Categoria:</label>
                <input type="text" id="nome" name="nome" required>
            </div>

            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" rows="4" required></textarea>
            </div>

            <button type="submit">Criar Categoria</button>
        </form>

        <a href="backoffice-blogue-categorias-index.php" class="voltar-btn">← Voltar às Categorias</a>
    </div>

</body>
</html>
