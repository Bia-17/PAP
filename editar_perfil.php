<?php
session_start();
require_once "conectar.php";

if (!isset($_SESSION['Email'])) {
    header("Location: conta.php");
    exit();
}

$email = $_SESSION['Email'];

$stmt = $con->prepare("SELECT * FROM utilizadores WHERE Email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    echo "Erro ao carregar perfil.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $morada = $_POST['morada'];

    $stmt_update = $con->prepare("UPDATE utilizadores SET Nome = ?, Email = ?, Telemóvel = ?, Morada = ? WHERE Id_Cliente = ?");
    $stmt_update->bind_param("ssssi", $nome, $email, $telefone, $morada, $user['Id_Cliente']);
    if ($stmt_update->execute()) {
        $msg = "Perfil atualizado com sucesso!";
    } else {
        $msg = "Erro ao atualizar perfil.";
    }
    $stmt_update->close();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/editar_perfil.css">
    <script src="js/menu.js" defer></script>
    <title>Editar Perfil</title>
</head>
<body>
    <header class="header">
        <div class="logo">
            <h1>Editar Perfil</h1>
        </div>
        <button class="terminar-sessao" onclick="window.location.href='logout.php'">Terminar Sessão</button>
    </header>

    <div class="container">
        <nav class="menu">
            <ul>
                <a href="pagina.php" class="btn-voltar">Voltar à Minha Conta</a>
            </ul>
        </nav>

        <div class="perfil">
            <h2>Atualize as suas informações</h2>

            <?php if (isset($msg)): ?>
                <div class="msg"><?php echo $msg; ?></div>
            <?php endif; ?>

            <form action="editar_perfil.php" method="POST">
                <div class="input-box">
                    <label for="nome">Nome</label>
                    <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($user['Nome']); ?>" required>
                </div>
                <div class="input-box">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['Email']); ?>" required>
                </div>
                <div class="input-box">
                    <label for="telefone">Telefone</label>
                    <input type="text" id="telefone" name="telefone" value="<?php echo htmlspecialchars($user['Telemóvel'] ?: ''); ?>">
                </div>
                <div class="input-box">
                    <label for="morada">Morada</label>
                    <input type="text" id="morada" name="morada" value="<?php echo htmlspecialchars($user['Morada'] ?: ''); ?>">
                </div>
                <button type="submit" class="btn-save">Salvar Alterações</button>
            </form>
        </div>
    </div>
</body>
</html>
