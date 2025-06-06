<?php
include_once(__DIR__ . '/../../conectar.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $conteudo = $_POST['conteudo'];
    $conclusao = $_POST['conclusao'];
    $id_categoria = $_POST['id_categoria'];

    $imagem = '';
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $imagem_dir = __DIR__ . '/../../imagens/';
        $imagem_nome = uniqid() . '-' . basename($_FILES['imagem']['name']);
        $imagem_caminho = $imagem_dir . $imagem_nome;

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $imagem_caminho)) {
            $imagem = 'imagens/' . $imagem_nome;
        } else {
            $imagem = '';
        }
    }

    // Inserir os dados na base de dados
    $sql = "INSERT INTO blogue_posts (Id_BCat, Título, Descrição, Conteúdo, Conclusão, Imagem, Data_Criação, Data_Atualização)
            VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())";
    
    $stmt = $con->prepare($sql);
    $stmt->bind_param("isssss", $id_categoria, $titulo, $descricao, $conteudo, $conclusao, $imagem);

    if ($stmt->execute()) {
        header("Location: backoffice-blogue-index.php?mensagem=criado");
        exit;
    } else {
        echo "Erro ao criar o post: " . $con->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Criar Post - Blogue</title>
    <link rel="stylesheet" href="/PAP/css/blogue-criar.css">
</head>
<body>
    <div class="form-container">
        <h1>Criar Novo Post</h1>

        <form action="backoffice-blogue-criar.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" required>
            </div>

            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="conteudo">Conteúdo:</label>
                <textarea id="conteudo" name="conteudo" rows="6" required></textarea>
            </div>

            <div class="form-group">
                <label for="conclusao">Conclusão:</label>
                <textarea id="conclusao" name="conclusao" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="id_categoria">Categoria:</label>
                <select id="id_categoria" name="id_categoria" required>
                    <?php
                    $sql_categoria = "SELECT * FROM blogue_categorias";
                    $result_categoria = $con->query($sql_categoria);
                    while ($categoria = $result_categoria->fetch_assoc()) {
                        echo "<option value='" . $categoria['Id_BCat'] . "'>" . $categoria['Nome'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="imagem">Imagem:</label>
                <input type="file" id="imagem" name="imagem" accept="image/*">
            </div>

            <button type="submit" class="submit-btn">Criar Post</button>
        </form>

        <a class="voltar-btn" href="backoffice-blogue-index.php">← Voltar ao Backoffice</a>
    </div>
</body>
</html>
