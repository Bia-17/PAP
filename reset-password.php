<?php
require_once 'conectar.php';

if (!isset($_GET['token'])) {
    die("Token inválido ou em falta.");
}

$token = $_GET['token'];
$erro = "";
$sucesso = "";

$stmt = $conn->prepare("SELECT Id_Cliente, token_expiry FROM utilizadores WHERE token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Token inválido.");
}

$reset = $result->fetch_assoc();

if (strtotime($reset['token_expiry']) < time()) {
    die("Token expirado. Por favor, faz um novo pedido de recuperação.");
}

$user_id = $reset['Id_Cliente'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $password = $_POST['password'] ?? "";
    $password_confirm = $_POST['password_confirm'] ?? "";

    if (empty($password) || empty($password_confirm)) {
        $erro = "Preencha ambos os campos.";
    } elseif ($password !== $password_confirm) {
        $erro = "As passwords não coincidem.";
    } elseif (strlen($password) < 6) {
        $erro = "A password deve ter pelo menos 6 caracteres.";
    } else {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE utilizadores SET password = ? WHERE Id_Cliente = ?");
        $stmt->bind_param("si", $password_hash, $user_id);
        if ($stmt->execute()) {
            $stmt = $conn->prepare("DELETE FROM utilizadores WHERE token = ?");
            $stmt->bind_param("s", $token);
            $stmt->execute();

            $sucesso = "Password atualizada com sucesso! Já pode entrar com a nova password.";
        } else {
            $erro = "Erro ao atualizar a password. Tenta novamente.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8" />
    <title>Redefinir Palavra-passe</title>
    <link rel="stylesheet" href="css/conta.css" />
</head>
<body>
    <main class="conteudo-principal">
        <div class="container">
            <h2>Redefinir Palavra-passe</h2>
            <?php if ($erro): ?>
                <p style="color:red;"><?php echo htmlspecialchars($erro); ?></p>
            <?php endif; ?>
            <?php if ($sucesso): ?>
                <p style="color:green;"><?php echo htmlspecialchars($sucesso); ?></p>
                <a href="conta.php">Ir para login</a>
            <?php else: ?>
            <form method="POST" action="">
                <div class="input-group">
                    <label for="password">Nova Password</label>
                    <input type="password" name="password" id="password" required />
                </div>
                <div class="input-group">
                    <label for="password_confirm">Confirmar Nova Password</label>
                    <input type="password" name="password_confirm" id="password_confirm" required />
                </div>
                <button type="submit" class="btn">Atualizar Password</button>
            </form>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
