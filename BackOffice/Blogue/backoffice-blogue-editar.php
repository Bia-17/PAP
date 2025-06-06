<?php
include_once(__DIR__ . '/../../conectar.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('ID do post não foi fornecido!');
}

$id = $_GET['id'];

$sql = "SELECT * FROM blogue_posts WHERE Id_Posts = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

if (!$post) {
    die('Post não encontrado!');
}

// categorias
$catSql = "SELECT * FROM blogue_categorias";
$catResult = $con->query($catSql);

// Atualizar post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $conteudo = $_POST['conteudo'];
    $conclusao = $_POST['conclusao'];
    $id_bcat = $_POST['id_bcat'];
    $imagem = $post['Imagem'];

    if (!empty($_FILES['imagem']['name'])) {
        $pasta = '../../imagens/blogue/';
        if (!is_dir($pasta)) {
            mkdir($pasta, 0777, true);
        }

        $nomeImagem = uniqid() . '_' . $_FILES['imagem']['name'];
        $caminhoCompleto = $pasta . $nomeImagem;

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoCompleto)) {
            $imagem = 'imagens/blogue/' . $nomeImagem;

            // Apagar imagem anterior
            if (!empty($post['Imagem']) && file_exists("../../" . $post['Imagem'])) {
                unlink("../../" . $post['Imagem']);
            }
        }
    }

    $sql = "
        UPDATE blogue_posts SET 
            Título = ?, 
            Descrição = ?, 
            Conteúdo = ?, 
            Conclusão = ?, 
            Id_BCat = ?, 
            Imagem = ?, 
            Data_Atualização = NOW()
        WHERE Id_Posts = ?
    ";

    $stmt = $con->prepare($sql);
    $stmt->bind_param("sssssis", $titulo, $descricao, $conteudo, $conclusao, $id_bcat, $imagem, $id);

    if ($stmt->execute()) {
        header("Location: backoffice-blogue-index.php?mensagem=editado");
        exit;
    } else {
        echo "Erro ao atualizar: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Post</title>
    <link rel="stylesheet" href="/PAP/css/blogue-editar.css">
</head>
<body>

<div class="editar-container">
    <h1>Editar Post do Blogue</h1>

    <form method="post" enctype="multipart/form-data">
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="titulo" value="<?= htmlspecialchars($post['Título']) ?>" required>

        <label for="descricao">Descrição:</label>
        <textarea name="descricao" id="descricao" rows="3" required><?= htmlspecialchars($post['Descrição']) ?></textarea>

        <label for="conteudo">Conteúdo:</label>
        <textarea name="conteudo" id="conteudo" rows="6" required><?= htmlspecialchars($post['Conteúdo']) ?></textarea>

        <label for="conclusao">Conclusão:</label>
        <textarea name="conclusao" id="conclusao" rows="3"><?= htmlspecialchars($post['Conclusão']) ?></textarea>

        <label for="id_bcat">Categoria:</label>
        <select name="id_bcat" id="id_bcat" required>
            <?php while ($cat = $catResult->fetch_assoc()): ?>
                <option value="<?= $cat['Id_BCat'] ?>" <?= $cat['Id_BCat'] == $post['Id_BCat'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['Nome']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label>Imagem Atual:</label><br>
        <?php if (!empty($post['Imagem'])): ?>
            <img src="/PAP/<?= htmlspecialchars($post['Imagem']) ?>" alt="Imagem atual" width="150"><br>
        <?php else: ?>
            <p>Sem imagem</p>
        <?php endif; ?>

        <label for="imagem">Nova Imagem (opcional):</label>
        <input type="file" name="imagem" id="imagem" accept="image/*">

        <button type="submit">Guardar Alterações</button>
        <a class="voltar-btn" href="backoffice-blogue-index.php">← Voltar</a>
    </form>
</div>

</body>
</html>
