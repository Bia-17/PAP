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
    die("Categoria não encontrada!");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $delete_sql = "DELETE FROM categorias WHERE Id_Categoria = ?";
    $delete_stmt = $con->prepare($delete_sql);
    $delete_stmt->bind_param("i", $id_categoria);
    $delete_stmt->execute();

    header("Location: backoffice-categorias-index.php?mensagem=eliminada");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Categoria</title>
    <link rel="stylesheet" href="/PAP/css/categorias-eliminar.css">
</head>
<body>

    <div class="eliminar-container">
        <h1>Eliminar Categoria</h1>

        <p>Tem a certeza que quer eliminar a categoria <strong>"<?= htmlspecialchars($categoria['Nome']) ?>"</strong>?</p>

        <form method="POST">
            <button type="submit">Sim, Eliminar</button>
            <a href="backoffice-categorias-index.php" class="voltar-btn">Cancelar</a>
        </form>
    </div>

</body>
</html>
