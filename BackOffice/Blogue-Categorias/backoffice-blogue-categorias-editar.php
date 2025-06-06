<?php
include_once(__DIR__ . '/../../conectar.php');

// Verificar se o ID da categoria foi fornecido
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('ID da categoria não foi fornecido!');
}

$id_categoria = $_GET['id'];

$sql = "SELECT * FROM blogue_categorias WHERE Id_BCat = ?";
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

    $update_sql = "UPDATE blogue_categorias SET Nome = ?, Descrição = ? WHERE Id_BCat = ?";
    $update_stmt = $con->prepare($update_sql);
    $update_stmt->bind_param("ssi", $nome, $descricao, $id_categoria);
    $update_stmt->execute();

    header("Location: backoffice-blogue-categorias-index.php?mensagem=alterada");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Categoria - Blogue</title>
    <link rel="stylesheet" href="/PAP/css/blogue-categorias-editar.css">
</head>
<body>

    <div class="editar-container">
        <h1>Editar Categoria</h1>

        <form action="" method="POST">
            <div class="form-group">
                <label for="nome">Nome da Categoria:</label>
                <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($categoria['Nome']) ?>" required>
            </div>

            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" rows="4" required><?= htmlspecialchars($categoria['Descrição']) ?></textarea>
            </div>

            <button type="submit">Atualizar Categoria</button>
        </form>

        <a href="backoffice-blogue-categorias-index.php" class="voltar-btn">← Voltar às Categorias</a>
    </div>

</body>
</html>
