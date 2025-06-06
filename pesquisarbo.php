<?php
include_once('verificar-acesso.php');
include_once(__DIR__ . '/../conectar.php');

$termo = isset($_GET['q']) ? trim($_GET['q']) : '';

if (empty($termo)) {
    header('Location: backoffice-index.php');
    exit();
}

$termo_like = '%' . $termo . '%';
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Resultados da Pesquisa</title>
  <link rel="stylesheet" href="/PAP/css/backoffice.css">
</head>
<body>
<div class="container">

    <main class="main">
        <header class="header">
        <form action="pesquisarbo.php" method="get" class="search-form">
            <input type="text" name="q" placeholder="🔍 Pesquisar..." value="<?php echo htmlspecialchars($termo); ?>" class="search" />
        </form>
        <div class="user-menu">
            <span class="user-name"><?php echo $_SESSION['Nome']; ?></span> ▼
            <div class="dropdown">
            <ul>
                <li><a href="/PAP/logout.php">Terminar Sessão</a></li>
            </ul>
            </div>
        </div>
        </header>

        <section class="cards">
        <h2>Resultados para: "<?php echo htmlspecialchars($termo); ?>"</h2>

        <!-- Categorias -->
        <h3>Categorias</h3>
        <?php
        $stmt = $con->prepare("SELECT Nome, Id_Categoria FROM categorias WHERE Nome LIKE ?");
        $stmt->bind_param("s", $termo_like);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0): ?>
            <table>
            <thead><tr><th>Nome</th></tr></thead>
            <tbody>
            <?php while ($row = $res->fetch_assoc()): ?>
                <tr><td><?= htmlspecialchars($row['Nome']) ?></td></tr>
                <td><a href="Categorias/backoffice-categorias-index.php?id=<?= $row['Id_Categoria'] ?>" class="btn-ver">Ver Detalhes</a></td>
            <?php endwhile; ?>
            </tbody>
            </table>
        <?php else: ?>
            <p>Sem resultados em categorias.</p>
        <?php endif;
        $stmt->close();
        ?>

        <!-- Blogue Categorias -->
        <h3>Blogue Categorias</h3>
        <?php
        $stmt = $con->prepare("SELECT Id_BCat, Nome, Descrição FROM blogue_categorias WHERE Nome LIKE ? OR Descrição LIKE ?");
        $stmt->bind_param("ss", $termo_like, $termo_like);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0): ?>
            <table>
            <thead><tr><th>ID</th><th>Nome</th><th>Descrição</th></tr></thead>
            <tbody>
            <?php while ($row = $res->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['Id_BCat']) ?></td>
                    <td><?= htmlspecialchars($row['Nome']) ?></td>
                    <td><?= htmlspecialchars($row['Descrição']) ?></td>   
                </tr>
                <td><a href="Blogue-Categorias/backoffice-blogue-categorias-index.php?id=<?= $row['Id_BCat'] ?>" class="btn-ver">Ver Detalhes</a></td>
            <?php endwhile; ?>
            </tbody>
            </table>
        <?php else: ?>
            <p>Sem resultados em categorias do blogue.</p>
        <?php endif;
        $stmt->close();
        ?>

        <!-- Blogue Posts -->
        <h3>Blogue Posts</h3>
        <?php
        $stmt = $con->prepare("SELECT Id_Posts, Título, Descrição, Conteúdo FROM blogue_posts WHERE Título LIKE ? OR Descrição LIKE ? OR Conteúdo LIKE ?");
        $stmt->bind_param("sss", $termo_like, $termo_like, $termo_like);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0): ?>
            <table>
            <thead><tr><th>ID</th><th>Título</th><th>Descrição</th><th>Conteúdo</th></tr></thead>
            <tbody>
            <?php while ($row = $res->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['Id_Posts']) ?></td>
                    <td><?= htmlspecialchars($row['Título']) ?></td>
                    <td><?= htmlspecialchars($row['Descrição']) ?></td>
                    <td><?= htmlspecialchars(mb_strimwidth($row['Conteúdo'], 0, 100, '...')) ?></td>
                </tr>
                <td><a href="Blogue/backoffice-blogue-detalhes.php?id=<?= $row['Id_Posts'] ?>" class="btn-ver">Ver Detalhes</a></td>
            <?php endwhile; ?>
            </tbody>
            </table>
        <?php else: ?>
            <p>Sem resultados em posts do blogue.</p>
        <?php endif;
        $stmt->close();
        ?>


        <!-- Plantas -->
        <h3>Plantas</h3>
        <?php
        $stmt = $con->prepare("SELECT Id_Planta, Nome_Comum, Nome_Científico, Preço FROM plantas WHERE Nome_Comum LIKE ?");
        $stmt->bind_param("s", $termo_like);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0): ?>
            <table>
            <thead><tr><th>Nome Comum</th><th>Nome Científico</th><th>Preço</th></tr></thead>
            <tbody>
            <?php while ($row = $res->fetch_assoc()): ?>
                <tr><td><?= htmlspecialchars($row['Nome_Comum']) ?></td><td><?= htmlspecialchars($row['Nome_Científico']) ?></td><td><?= htmlspecialchars($row['Preço']) ?> €</td></tr>
                <td><a href="Plantas/backoffice-plantas-detalhes.php?id=<?= $row['Id_Planta'] ?>" class="btn-ver">Ver Detalhes</a></td>
            <?php endwhile; ?>
            </tbody>
            </table>
        <?php else: ?>
            <p>Sem resultados em plantas.</p>
        <?php endif;
        $stmt->close();
        ?>

        <!-- Reviews -->
        <h3>Reviews</h3>
        <?php
        $stmt = $con->prepare("SELECT id_review, review_texto FROM reviews WHERE id_review LIKE ?");
        $stmt->bind_param("s", $termo_like);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0): ?>
            <table>
            <thead><tr><th>Id Review</th><th>Comentário</th></tr></thead>
            <tbody>
            <?php while ($row = $res->fetch_assoc()): ?>
                <tr><td><?= htmlspecialchars($row['id_review']) ?></td><td><?= htmlspecialchars($row['review_texto']) ?></td></tr>
                <td><a href="Reviews/backoffice-reviews-detalhes.php?id=<?= $row['id_review'] ?>" class="btn-ver">Ver Detalhes</a></td>
            <?php endwhile; ?>
            </tbody>
            </table>
        <?php else: ?>
            <p>Sem resultados em reviews.</p>
        <?php endif;
        $stmt->close();
        ?>

        <!-- Pedidos -->
        <h3>Pedidos</h3>
        <?php
        $stmt = $con->prepare("
            SELECT p.Id_Pedido, p.Data_Criação, u.Nome 
            FROM pedidos p 
            JOIN utilizadores u ON p.Id_Cliente = u.Id_Cliente 
            WHERE p.Id_Pedido LIKE ? OR u.Nome LIKE ?");
        $stmt->bind_param("ss", $termo_like, $termo_like);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0): ?>
            <table>
            <thead><tr><th>ID Pedido</th><th>Data</th><th>Cliente</th></tr></thead>
            <tbody>
            <?php while ($row = $res->fetch_assoc()): ?>
                <tr><td><?= $row['Id_Pedido'] ?></td><td><?= $row['Data_Criação'] ?></td><td><?= htmlspecialchars($row['Nome']) ?></td></tr>
                <td><a href="Pedidos/backoffice-pedidos-detalhes.php?id=<?= $row['Id_Pedido'] ?>" class="btn-ver">Ver Detalhes</a></td>
            <?php endwhile; ?>
            </tbody>
            </table>
        <?php else: ?>
            <p>Sem resultados em pedidos.</p>
        <?php endif;
        $stmt->close();
        ?>
    </section>
  </main>
</div>
</body>
</html>
