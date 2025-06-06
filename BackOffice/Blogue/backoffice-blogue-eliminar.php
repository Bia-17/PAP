<?php
include_once(__DIR__ . '/../../conectar.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('ID do post não foi fornecido!');
}

$id_post = $_GET['id'];

$sql_select = "SELECT Imagem FROM blogue_posts WHERE Id_Posts = ?";
$stmt_select = $con->prepare($sql_select);
$stmt_select->bind_param("i", $id_post);
$stmt_select->execute();
$result = $stmt_select->get_result();
$post = $result->fetch_assoc();

if ($post && !empty($post['Imagem']) && file_exists(__DIR__ . '/../../' . $post['Imagem'])) {
    unlink(__DIR__ . '/../../' . $post['Imagem']);
}

$sql = "DELETE FROM blogue_posts WHERE Id_Posts = ?";
$stmt = $con->prepare($sql);

if (!$stmt) {
    die('Erro ao preparar a eliminação: ' . $con->error);
}

$stmt->bind_param("i", $id_post);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    header("Location: backoffice-blogue-index.php?mensagem=eliminado");
    exit;
} else {
    echo "Erro ao eliminar o post.";
}
?>
