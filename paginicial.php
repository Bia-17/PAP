<?php
session_start();

if (isset($_SESSION['msg_sucesso'])) {
    $msg = $_SESSION['msg_sucesso'];
    echo "<script>alert('{$msg}');</script>";
    unset($_SESSION['msg_sucesso']);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Inicío</title>
        <link rel="stylesheet" type="text/css" href="css/paginicial.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://kit.fontawesome.com/76ed8667ce.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link rel="stylesheet" href="css/swiper-bundle.min.css"/>
        <link rel="stylesheet" href="css/footer.css">
    </head>
    <body>
        <section id="pag1" class="pag1">
        <div class="banner">
            <video autoplay muted loop>
            <source src="imagens/video.mp4" alt="Imagem 1"/>
            </video>
        </div>
        <button class="menu-toggle" id="menuToggle">
            <span class="material-symbols-outlined">menu</span>
        </button>
        <div class="barralado collapsed">
            <header class="header">
                <button class="toggler barralado-toggler">
                    <span class="material-symbols-outlined">menu</span>
                </button>
            </header>
            <ul class="lista-nav primary-nav">
                <li class="conteudo-nav">
                    <a href="paginicial.php" class="link-nav">
                        <span class="nav-icon material-symbols-outlined">home</span>
                        <span class="label-nav">Início</span>
                    </a>
                    <span class="tooltip">Início</span>
                </li>
                <li class="conteudo-nav">
                    <a href="plantas.php" class="link-nav">
                        <span class="nav-icon material-symbols-outlined">
                            psychiatry
                            </span>
                        <span class="label-nav">Plantas</span>
                    </a>
                    <span class="tooltip">Plantas</span>
                </li>
                <li class="conteudo-nav">
                    <a href="arvores.php" class="link-nav">
                        <span class="nav-icon material-symbols-outlined">nature</span>
                        <span class="label-nav">Árvores e Arbustos</span>
                    </a>
                    <span class="tooltip">Árvores e Arbustos</span>
                </li>
                <li class="conteudo-nav">
                    <a href="FAQ.html" class="link-nav">
                        <span class="nav-icon material-symbols-outlined">quiz</span>
                        <span class="label-nav">FAQ's</span>
                    </a>
                    <span class="tooltip">FAQ's</span>
                </li>
                <li class="conteudo-nav">
                    <a href="sobre.html" class="link-nav">
                        <span class="nav-icon material-symbols-outlined">groups</span>
                        <span class="label-nav">Sobre Nós</span>
                    </a>
                    <span class="tooltip">Sobre Nós</span>
                </li>
                <li class="conteudo-nav">
                    <a href="inicioblog.php" class="link-nav">
                        <span class="nav-icon material-symbols-outlined">article</span>
                        <span class="label-nav">Blogue</span>
                    </a>
                    <span class="tooltip">Blogue</span>
                </li>
            </ul>
            <ul class="lista-nav secondary-nav">
                <li class="conteudo-nav">
                    <a href="conta.php" class="link-nav">
                        <span class="nav-icon material-symbols-outlined">account_circle</span>
                        <span class="label-nav">Conta</span>
                        <span class="tooltip">Conta</span>
                    </a>
                </li>
                <li class="conteudo-nav">
                    <a href="carrinho.php" class="link-nav">
                        <span class="nav-icon material-symbols-outlined">shopping_cart</span>
                        <span class="label-nav">Carrinho</span>
                        <span class="tooltip">Carrinho</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="titulo">
            <h1>Welcome to</h1>
            <div class="logo">
                <img src="imagens/logo2.png" alt=""/>
            </div>
        <div class="seta" onclick="scrollToSection()">
            <p>Descubra Mais</p>
            <i class="fa-solid fa-arrow-down"></i>
        </div>
        </div>
        <script src="js/toggle.js"></script>
        <div class="header1">
            
                <div class="caixa-pesquisa">
                    <form id="form-pesquisa" action="pesquisar.php" method="GET">
                        <input type="text" name="q" placeholder="Pesquisar">
                        <button type="submit">
                            <span class="material-symbols-outlined procurar">search</span>
                        </button>
                    </form>
                <div class="resultados"></div>
                </div>
        </div>
        <script src="pesquisa.js"></script>

    </section>
        <section id="pag2" class="pag2">
            <main>
        
            <div class="nov">
                <h1>Novidades</h1>
            </div>
            <div class="cards-container">
            <?php
            include_once 'conectar.php';

            $query="SELECT * FROM plantas ORDER BY Id_Planta DESC LIMIT 4";
            $result=mysqli_query($con, $query);

            if($result->num_rows > 0){
                while($planta=$result->fetch_assoc()){
            ?>
            
                <div class="card-nov">

                    <div class="imagem">
                        <?php
                            $imagens = explode(',', $planta['Imagem']);
                            $primeira_imagem = trim($imagens[0]);
                        ?>
                        <img src="<?= htmlspecialchars($primeira_imagem) ?>" alt="Imagem">
                    </div>
                    <div class="favoritos">
                        <p class="nome_planta"><?php echo $planta["Nome_Científico"]; ?></p>
                        <p class="preço">€<?php echo $planta["Preço"]; ?></p>
                    </div>
                    <form action="planta.php" method="GET">
                        <input type="hidden" name="id" value="<?php echo $planta['Id_Planta']; ?>">
                        <button type="submit" class="ver">Ver</button>
                    </form>
                </div>

                <?php
            }
        } else {
            echo "Nenhuma planta recente encontrada";
        }

        ?> 
        </div>
        <script>
        function scrollToSection() {
            document.getElementById("pag2").scrollIntoView({ behavior: 'smooth' });
        }
        </script>
        </main>
    </body>
</html>