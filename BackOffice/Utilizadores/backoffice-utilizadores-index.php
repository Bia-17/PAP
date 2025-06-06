<?php
include_once(__DIR__ . '/../../conectar.php');

$sql = "SELECT * FROM utilizadores";
$result = $con->query($sql);

if (isset($_GET['mensagem']) && $_GET['mensagem'] === 'desativado'): ?>
    <div class="mensagem-sucesso">🛑 Utilizador desativado com sucesso!</div>
<?php endif;

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Utilizadores - Backoffice</title>
    <link rel="stylesheet" href="/PAP/css/blogue-index.css">
</head>
<body>

    <h1>Gestão de Utilizadores</h1>

    <a class="create-btn" href="backoffice-utilizadores-criar.php">Criar Novo Utilizador</a>

    <a href="../backoffice-index.php" class="voltar-btn">
        <button type="button">← Voltar ao Backoffice</button>
    </a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Telemóvel</th>
                <th>Email</th>
                <th>Morada</th>
                <th>Cargo</th>
                <th>Notificações</th>
                <th>Data de Criação</th>
                <th>Estado</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while($utilizador = $result->fetch_assoc()): ?>
        <tr class="<?= $utilizador['Ativo'] ? '' : 'desativado' ?>">
        <td><?= $utilizador['Id_Cliente'] ?></td>
        <td><?= htmlspecialchars($utilizador['Nome']) ?></td>
        <td><?= htmlspecialchars($utilizador['Telemóvel']) ?></td>
        <td><?= htmlspecialchars($utilizador['Email']) ?></td>
        <td><?= htmlspecialchars($utilizador['Morada']) ?></td>
        <td><?= htmlspecialchars($utilizador['cargos']) ?></td>
        <td><?= $utilizador['Notificacoes_Email'] ? 'Sim' : 'Não' ?></td>
        <td><?= $utilizador['Data_Criação'] ?></td>
        <td><?= $utilizador['Ativo'] ? 'Ativo' : 'Desativado' ?></td>
        <td class="actions">
            <a href="backoffice-utilizadores-editar.php?id=<?= $utilizador['Id_Cliente'] ?>">Editar</a>
            <a href="backoffice-utilizadores-detalhes.php?id=<?= $utilizador['Id_Cliente'] ?>">Detalhes</a>
            <a href="backoffice-utilizadores-eliminar.php?id=<?= $utilizador['Id_Cliente'] ?>" onclick="return confirm('Tem a certeza que quer desativar este utilizador?')">Desativar</a>
        </td>
    </tr>
<?php endwhile; ?>

        </tbody>
    </table>

</body>
</html>
