<?php
include_once(__DIR__ . '/../../conectar.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('ID da categoria não foi fornecido!');
}

$id_categoria = $_GET['id'];

$sql = "SELECT * FROM categorias WHERE Id_Categoria = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id_categoria);
$stmt->execute();
$result = $stmt->get_result();
$categoria = $result->fetch_assoc();

if (!$categoria) {
    die('Categoria não encontrada!');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];

    $update_sql = "UPDATE categorias SET Nome = ?, Descrição = ? WHERE Id_Categoria = ?";
    $update_stmt = $con->prepare($update_sql);
    $update_stmt->bind_param("ssi", $nome, $descricao, $id_categoria);
    $update_stmt->execute();

    header("Location: backoffice-categorias-index.php?mensagem=alterada");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Categoria</title>
    <link rel="stylesheet" href="/PAP/css/categorias-editar.css">
</head>
<body>
    <div class="editar-container">
        <h1>Editar Categoria</h1>

        <form action="" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($categoria['Nome']) ?>" required>

            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" rows="4" required><?= htmlspecialchars($categoria['Descrição']) ?></textarea>

            <button type="submit">Atualizar Categoria</button>
        </form>

        <a href="backoffice-categorias-index.php" class="voltar-btn">← Voltar às Categorias</a>
    </div>
</body>
</html>
