<?php
session_start();
require_once "conectar.php";

if (!isset($_SESSION['Email'])) {
    header("Location: conta.php");
    exit();
}

if (isset($_SESSION['msg_sucesso'])) {
    $msg = $_SESSION['msg_sucesso'];
    echo "<script>alert('{$msg}');</script>";
    unset($_SESSION['msg_sucesso']);
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

$id_cliente = $user['Id_Cliente'];

$stmt_pedidos = $con->prepare("SELECT * FROM pedidos WHERE Id_Cliente = ? ORDER BY Data_Criação DESC");
$stmt_pedidos->bind_param("i", $id_cliente);
$stmt_pedidos->execute();
$pedidos_result = $stmt_pedidos->get_result();
$stmt_pedidos->close();

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/pagina.css">
    <script src="js/menu.js" defer></script>
    <title>A Minha Conta</title>
</head>
<body>
    <header class="header">
        <div class="logo">
            <h1>A Minha Conta</h1>
        </div>
        <button class="terminar-sessao" onclick="window.location.href='logout.php'">Terminar Sessão</button>
    </header>

    <div class="perfil">
        <h1><?php echo htmlspecialchars($user['Nome']); ?></h1>
        <h2><?php echo htmlspecialchars($user['Email']); ?></h2>
        <button class="btn-back" onclick="window.location.href='paginicial.php'">Voltar à Página Inicial</button>

    </div>

    <div class="container">
        <nav class="menu">
            <ul>
                <li><button onclick="showContent('info')">Informações Pessoais</button></li>
                <li><button onclick="showContent('historico')">Histórico de Compras</button></li>
                <li><button onclick="showContent('config')">Configurações</button></li>
                <li><button onclick="showContent('pagamento')">Meios de Pagamento</button></li>
            </ul>
        </nav>

        <div class="dashboard">
            <!-- Informações Pessoais -->
            <div id="info" class="content-section">
                <h2>Informações Pessoais</h2>
                <p>Administre a sua informação pessoal.</p>
                <div class="info-box"><strong>Nome:</strong> <?php echo htmlspecialchars($user['Nome']); ?></div>
                <div class="info-box"><strong>Email:</strong> <?php echo htmlspecialchars($user['Email']); ?></div>
                <div class="info-box"><strong>Telefone:</strong> <?php echo htmlspecialchars($user['Telemóvel'] ?: 'Não informado'); ?></div>
                <div class="info-box"><strong>Morada:</strong> <?php echo htmlspecialchars($user['Morada'] ?: 'Não informado'); ?></div>
                <button class="btn-edit" onclick="window.location.href='editar_perfil.php'">Editar Informações</button>
            </div>

            <!-- Histórico de compras -->
            <div id="historico" class="content-section">
                <h2>Histórico de Compras</h2>
                <p>Aqui pode visualizar todos os seus pedidos anteriores.</p>

                <?php if ($pedidos_result->num_rows > 0): ?>
                    <table class="historico-pedidos">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Valor Total</th>
                                <th>Status</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($pedido = $pedidos_result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($pedido['Data_Criação']); ?></td>
                                    <td><?php echo htmlspecialchars($pedido['Total']); ?></td>
                                    <td><?php echo htmlspecialchars($pedido['Status_p']); ?></td>
                                    <td><a href="detalhes_pedido.php?id=<?php echo $pedido['Id_Pedido']; ?>">Ver Detalhes</a></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Não há pedidos registados.</p>
                <?php endif; ?>
            </div>

            <!-- Configurações -->
            <div id="config" class="content-section">
                <h2>Configurações</h2>
                <p>Gerir as suas preferências de conta e segurança.</p>

                <div class="config-section">
                    <h3>Alterar Senha</h3>
                    <form action="atualizar_config.php" method="POST">
                        <label for="senha_atual">Senha Atual</label>
                        <input type="password" id="senha_atual" name="senha_atual" required>

                        <label for="nova_senha">Nova Senha</label>
                        <input type="password" id="nova_senha" name="nova_senha" required>

                        <label for="confirmar_senha">Confirmar Nova Senha</label>
                        <input type="password" id="confirmar_senha" name="confirmar_senha" required>

                        <button type="submit" name="alterar_senha" class="btn-save">Guardar Alterações</button>
                    </form>
                </div>

                <div class="config-section">
                    <h3>Preferências de Notificações</h3>
                    <form action="atualizar_config.php" method="post">
                        <label>
                            <input type="checkbox" name="notificacoes_email" value="1"
                                <?php echo (!empty($user['Notificacoes_Email']) ? 'checked' : ''); ?>>
                            Receber notificações por email
                        </label>
                        <button type="submit">Guardar Alterações</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
