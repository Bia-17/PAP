<?php
include_once(__DIR__ . '/../../conectar.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('ID do utilizador não foi fornecido!');
}

$id = $_GET['id'];

$sql = "SELECT * FROM utilizadores WHERE Id_Cliente = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$utilizador = $result->fetch_assoc();

if (!$utilizador) {
    die('Utilizador não encontrado!');
}

// Atualizar utilizador
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $telemovel = $_POST['telemovel'];
    $email = $_POST['email'];
    $morada = $_POST['morada'];
    $cargos = $_POST['cargos'];
    $notificacoes = isset($_POST['notificacoes']) ? 1 : 0;
    $ativo = isset($_POST['ativo']) ? 1 : 0;

    $sql = "
        UPDATE utilizadores SET 
            Nome = ?,
            Telemóvel = ?,
            Email = ?,
            Morada = ?,
            cargos = ?,
            Notificacoes_Email = ?,
            Ativo = ?
        WHERE Id_Cliente = ?
    ";

    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssssssii", $nome, $telemovel, $email, $morada, $cargos, $notificacoes, $ativo, $id);

    if ($stmt->execute()) {
        header("Location: backoffice-utilizadores-index.php?mensagem=editado");
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
    <title>Editar Utilizador</title>
    <link rel="stylesheet" href="/PAP/css/blogue-editar.css">
</head>
<body>

<div class="editar-container">
    <h1>Editar Utilizador</h1>

    <form method="post">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($utilizador['Nome']) ?>" required>

        <label for="telemovel">Telemóvel:</label>
        <input type="text" name="telemovel" id="telemovel" value="<?= htmlspecialchars($utilizador['Telemóvel']) ?>">

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($utilizador['Email']) ?>" required>

        <label for="morada">Morada:</label>
        <input type="text" name="morada" id="morada" value="<?= htmlspecialchars($utilizador['Morada']) ?>">

        <label for="cargos">Cargo:</label>
        <input type="text" name="cargos" id="cargos" value="<?= htmlspecialchars($utilizador['cargos']) ?>">

        <label for="notificacoes">Receber Notificações por Email:</label>
        <input type="checkbox" name="notificacoes" id="notificacoes" <?= $utilizador['Notificacoes_Email'] ? 'checked' : '' ?> >

        <div class="checkbox-container">
            <label for="ativo">Ativo:</label>
            <input type="checkbox" name="ativo" id="ativo" <?= $utilizador['Ativo'] ? 'checked' : '' ?> >
        </div>

        <button type="submit">Guardar Alterações</button>
        <a class="voltar-btn" href="backoffice-utilizadores-index.php">← Voltar</a>
    </form>
</div>

</body>
</html>
