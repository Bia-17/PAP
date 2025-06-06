<?php
include_once(__DIR__ . '/../../conectar.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('ID da categoria não foi fornecido!');
}

$id_categoria = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
    // Eliminar categoria
    $delete_sql = "DELETE FROM blogue_categorias WHERE Id_BCat = ?";
    $delete_stmt = $con->prepare($delete_sql);
    $delete_stmt->bind_param("i", $id_categoria);
    $delete_stmt->execute();

    header("Location: backoffice-blogue-categorias-index.php?mensagem=eliminada");
    exit();
}

$sql = "SELECT * FROM blogue_categorias WHERE Id_BCat = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id_categoria);
$stmt->execute();
$result = $stmt->get_result();
$categoria = $result->fetch_assoc();

if (!$categoria) {
    die('Categoria não encontrada!');
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Categoria - Blogue</title>
    <link rel="stylesheet" href="/PAP/css/blogue-categorias-editar.css">
</head>
<body>

    <div class="editar-container">
        <h1>Eliminar Categoria</h1>

        <p>Tem certeza de que deseja eliminar a categoria <strong><?= htmlspecialchars($categoria['Nome']) ?></strong>?</p>

        <form action="" method="POST">
            <button type="submit" name="eliminar">Eliminar Categoria</button>
        </form>

        <a href="backoffice-blogue-categorias-index.php" class="voltar-btn">← Voltar às Categorias</a>
    </div>

</body>
</html>
