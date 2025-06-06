<?php
include_once('verificar-acesso.php');

include_once(__DIR__ . '/../conectar.php');

$sql_clientes = "SELECT COUNT(*) AS total_clientes FROM utilizadores";
$result_clientes = $con->query($sql_clientes);
$total_clientes = 0;
if ($result_clientes) {
    $row = $result_clientes->fetch_assoc();
    $total_clientes = $row['total_clientes'];
}

$sql_pedidos = "SELECT COUNT(*) AS total_pedidos FROM pedidos";
$result_pedidos = $con->query($sql_pedidos);
$total_pedidos = 0;
if ($result_pedidos) {
    $row = $result_pedidos->fetch_assoc();
    $total_pedidos = $row['total_pedidos'];
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sementes & Raízes</title>
  <link rel="stylesheet" href="/PAP/css/backoffice.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
  <div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <h2 class="logo"><span class="material-symbols-outlined">psychiatry</span> Sementes & Raízes</h2>
      <nav>
        <a class="nav-item selected"><span class="material-symbols-outlined">space_dashboard</span> Painel</a>
        <a href="Utilizadores/backoffice-utilizadores-index.php" class="nav-item"><span class="material-symbols-outlined">person</span> Utilizadores</a>
        <a href="Plantas/backoffice-plantas-index.php" class="nav-item"><span class="material-symbols-outlined">potted_plant</span> Plantas</a>
        <a href="Pedidos/backoffice-pedidos-index.php" class="nav-item"><span class="material-symbols-outlined">package_2</span>Pedidos</a>
        <a href="Blogue/backoffice-blogue-index.php" class="nav-item"><span class="material-symbols-outlined">description</span> Blogue</a>
        <a href="Blogue-Categorias/backoffice-blogue-categorias-index.php" class="nav-item"><span class="material-symbols-outlined">article</span> Blogue Categorias</a>
        <a href="Categorias/backoffice-categorias-index.php" class="nav-item"><span class="material-symbols-outlined">category</span> Categorias</a>
        <a href="Reviews/backoffice-reviews-index.php" class="nav-item"><span class="material-symbols-outlined">reviews</span> Reviews</a>
      </nav>
    </aside>

    <!-- Conteúdo principal -->
    <main class="main">
      <!-- Cabeçalho -->
      <header class="header">
        <form action="pesquisarbo.php" method="get" class="search-form">
          <input type="text" name="q" placeholder="🔍 Pesquisar..." class="search" required />
          <button type="submit" style="display: none;">Pesquisar</button>
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

      <!-- Cards -->
      <section class="cards">
        <div class="card">
          <div class="card-icon"><span class="material-symbols-outlined">person</span></div>
          <div>
            <p>Número Total de Clientes</p>
            <h2><?= $total_clientes ?></h2>
          </div>
        </div>
        <div class="card">
          <div class="card-icon"><span class="material-symbols-outlined">shopping_cart</span></div>
          <div>
            <p>Número de Pedidos</p>
            <h2><?= $total_pedidos ?></h2>
          </div>
        </div>
      </section>
    </main>
  </div>
  <script>
    document.querySelector('.user-name').addEventListener('click', function() {
      const dropdown = document.querySelector('.dropdown');
      dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
    });
    document.addEventListener('click', function(event) {
      if (!event.target.closest('.user-menu')) {
        document.querySelector('.dropdown').style.display = 'none';
      }
    });
  </script>
</body>
</html>
