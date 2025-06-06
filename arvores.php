<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="css/arvores.css">
    <link rel="stylesheet" href="css/barralado.css">
    <link rel="stylesheet" href="css/footer.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/76ed8667ce.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>Plantas</title>
</head>
<body>
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
        <script src="js/toggle.js"></script>
        <section id="pag1" class="pag1">
<!-- Filtro -->

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
            <script src="pesquisa.js"></script>
            </div>
            <div class="categoria-buttons">
                <form method="GET">

            <?php

            include_once 'conectar.php';

            $posts="SELECT * FROM plantas WHERE Id_Categoria IN (3,4,5,10,11,12,13)";
            $cat="SELECT * FROM categorias WHERE Id_Categoria IN (3,4,5,10,11,12,13)";
            $all_posts=$con->query($posts);
            $filtro=mysqli_query($con, $cat);

            if(mysqli_num_rows($filtro)>0)
            {
                foreach($filtro as $listafiltro)
                {
                    $catselec=isset($_GET['categoria']) ? $_GET['categoria'] : [];;
                    if(isset($_GET['categoria']))
                    {
                        $catselec=$_GET['categoria'];
                    }
                    ?>
                    <div class="cat-item">
                    <button type="submit" name="categoria[]" value="<?=$listafiltro['Id_Categoria'] ?>"
                        <?php if(in_array($listafiltro['Id_Categoria'],$catselec)){ echo "catselect";} ?>
                    ><?= $listafiltro['Nome']; ?></button>
                    
                </div>
                <?php
                }
            }
            else
            {
                echo "sem resultados";
            }
            ?>
                </form>
            </div>
        </div>
<main>

    <?php
        if(isset($_GET['categoria']) && !empty($_GET['categoria']))
        {
            $plantchecked = $_GET['categoria'];
            foreach($plantchecked as $rowplant)
            {
                $products = "SELECT * FROM plantas WHERE Id_Categoria IN ($rowplant)";
                $products_run = mysqli_query($con, $products);
                if(mysqli_num_rows($products_run) > 0)
                {
                    foreach($products_run as $proditems):
                        ?>
                        <div class="card">
                            <div class="imagem">
                                <?php
                                    $imagens = explode(',', $proditems['Imagem']);
                                    $primeira_imagem = trim($imagens[0]);
                                ?>
                                <img src="<?= htmlspecialchars($primeira_imagem) ?>" alt="Imagem">
                            </div>
                            <div class="favoritos">
                                <p class="nome_planta"><?php echo $proditems["Nome_Científico"]; ?></p>
                                <p class="preço">€<?php echo $proditems["Preço"]; ?></p>
                            </div>
                            <form action="planta.php" method="GET">
                                <input type="hidden" name="id" value="<?php echo $proditems['Id_Planta']; ?>">
                                <button type="submit" class="ver">Ver</button>
                            </form>
                        </div>
                        <script src="toggle.js"></script>
                    <?php
                    endforeach;
                }
                else
                {
                    echo "Sem resultados";
                }
            }
        }
        else
        {
            $products = "SELECT * FROM plantas WHERE Id_Categoria IN (3, 4, 5, 10, 11, 12, 13)";
            $products_run = mysqli_query($con, $products);
            if(mysqli_num_rows($products_run) > 0)
            {
                foreach($products_run as $proditems):
                    ?>
                    <div class="card">
                        <div class="imagem">
                            <?php
                                $imagens = explode(',', $proditems['Imagem']);
                                $primeira_imagem = trim($imagens[0]);
                            ?>
                            <img src="<?= htmlspecialchars($primeira_imagem) ?>" alt="Imagem">
                        </div>
                        <div class="favoritos">
                            <p class="nome_planta"><?php echo $proditems["Nome_Científico"]; ?></p>
                            <p class="preço">€<?php echo $proditems["Preço"]; ?></p>
                        </div>
                        <form action="planta.php" method="GET">
                            <input type="hidden" name="id" value="<?php echo $proditems['Id_Planta']; ?>">
                            <button type="submit" class="ver">Ver</button>
                        </form>
                    </div>
                    <script src="js/favorito.js"></script>
                <?php
                endforeach;
            }
            else
            {
                echo "Sem resultados";
            }
        }
    ?>

</main>
    </section>
    <section id="pag2" class="pag2">
<div class="footer">
            <div>
                <h3>Sobre</h3>
                <br><a href="sobre.html">Sobre Nós</a>
                <br><a href="inicioblog.php">Blogue</a>
            </div>
            <div>
                <h3>Informações</h3>
                <br><p>+351 967 500 772</p>
                <br><p>+351 969 892 694</p>
                <br><p>geral@sementesraizes.pt</p>
            </div>
            <div>
                <h3>Redes Sociais</h3>
                <div class="social-icons">
                    <a href="#"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#"><i class="fa-brands fa-pinterest"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            &copy; Sementes & Raízes 2025
        </div>
    </section>
</body>