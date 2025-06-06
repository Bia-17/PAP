<?php
include_once(__DIR__ . '/../../conectar.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $telemovel = $_POST['telemovel'];
    $email = $_POST['email'];
    $morada = $_POST['morada'];
    $cargo = $_POST['cargo'];
    $notificacoes = isset($_POST['notificacoes']) ? 1 : 0;
    $ativo = isset($_POST['ativo']) ? 1 : 0;

    $insert_sql = "INSERT INTO utilizadores 
        (Nome, Telemóvel, Email, Morada, cargos, Notificacoes_Email, Ativo) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($insert_sql);
    $stmt->bind_param("sssssii", $nome, $telemovel, $email, $morada, $cargo, $notificacoes, $ativo);
    $stmt->execute();

    header("Location: backoffice-utilizadores-index.php?mensagem=criado");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8" />
    <title>Criar Novo Utilizador</title>
    <link rel="stylesheet" href="/PAP/css/blogue-categorias-editar.css" />
</head>
<body>

<div class="editar-container">
    <h1>Criar Novo Utilizador</h1>

    <form action="" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required />

        <label for="telemovel">Telemóvel:</label>
        <input type="text" id="telemovel" name="telemovel" />

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required />

        <label for="morada">Morada:</label>
        <input type="text" id="morada" name="morada" />

        <label for="cargo">Cargo:</label>
        <input type="text" id="cargo" name="cargo" />

        <div class="checkbox-container">
            <input type="checkbox" id="notificacoes" name="notificacoes" />
            <label for="notificacoes">Receber Notificações por Email</label>
        </div>

        <div class="checkbox-container">
            <input type="checkbox" id="ativo" name="ativo" checked />
            <label for="ativo">Ativo</label>
        </div>

        <button type="submit">Criar Utilizador</button>
    </form>

    <a href="backoffice-utilizadores-index.php" class="voltar-btn">← Voltar aos Utilizadores</a>
</div>

</body>
</html>
