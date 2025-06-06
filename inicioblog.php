<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="stylesheet" href="css/inicioblog.css">
        <link rel="stylesheet" href="css/barralado.css">
        <script src="https://kit.fontawesome.com/76ed8667ce.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <title>Comunidade Verde</title>
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
            <div class="titulo">
                <h1>Comunidade Verde</h1>
                <p>Sementes & Raízes</p>
                <div class="social-icons1">
                    <a href="#"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#"><i class="fa-brands fa-pinterest"></i></a>
                </div>
            </div>
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

            <div class="categoria-buttons">
                <form method="GET">

            <?php

            include_once 'conectar.php';

            $posts="SELECT * FROM blogue_posts";
            $cat="SELECT * FROM blogue_categorias";
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
                    <button type="submit" name="categoria[]" value="<?=$listafiltro['Id_BCat'] ?>"
                        <?php if(in_array($listafiltro['Id_BCat'],$catselec)){ echo "catselect";} ?>
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
            <div class="card-container">
            <?php
                if(isset($_GET['categoria']) && !empty($_GET['categoria']))
                {
                    $postchecked = $_GET['categoria'];
                    foreach($postchecked as $rowpost)
                    {
                        $post = "SELECT * FROM blogue_posts WHERE Id_BCat IN ($rowpost)";
                        $post_run = mysqli_query($con, $post);
                        if(mysqli_num_rows($post_run) > 0)
                        {
                            foreach($post_run as $postitems):
                                ?>
                                
                                    <div class="card">
                                        <img src="<?php echo $postitems['Imagem']; ?>" alt="Imagem">
                                        <div class="card-box">
                                            <div class="card-content">
                                                <p class="nome_post"><?php echo $postitems["Título"]; ?></p>
                                                <form action="post.php" method="GET">
                                                    <input type="hidden" name="Id" value="<?php echo $postitems['Id_Posts']; ?>">
                                                    <button type="submit" class="ler">Ler Mais</button>
                                                </form>
                                                
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                endforeach;
                            }
                            else
                            {
                            echo "Nenhum post encontrado";
                            }
                        }
                    }
                    else
                    {
                        $post = "SELECT * FROM blogue_posts WHERE Id_BCat IN (1,2,3,4,5,6,7)";
                        $post_run = mysqli_query($con, $post);
                        if(mysqli_num_rows($post_run) > 0)
                        {
                            foreach($post_run as $postitems):
                                ?>
                                
                                    <div class="card">
                                        <img src="<?php echo $postitems['Imagem']; ?>" alt="Imagem">
                                        <div class="card-box">
                                            <div class="card-content">
                                                <p class="nome_post"><?php echo $postitems["Título"]; ?></p>
                                                <form action="post.php" method="GET">
                                                    <input type="hidden" name="Id" value="<?php echo $postitems['Id_Posts']; ?>">
                                                    <button type="submit" class="ler">Ler Mais</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                endforeach;
                    }
                    else{
                        echo "Sem resultados";
                    }
                }
                        ?> 
                    </div>
        </section>
        <section id="pag2" class="pag2">
            <div class="subs">
                <h1>Newsletter</h1>
                <p>Subscreve-te para receber notificações</p>
                <form id="newsletter" class="form" action="#" method="POST">
                    <div class="newsletter">
                        <label for="email"></label>
                        <input type="email" name="email" id="email" placeholder="Insira o seu email">
                    </div>
                    <div class="checkbox-container">
                        <input type="checkbox" id="conf" name="conf" value="conf">
                        <label for="conf">Ao subscrever, concordo em receber novidades e promoções através de emails e/ou mensagens de texto automáticas no número de telefone fornecido. Para mais informações, consulta os Termos de Serviço e Política de Privacidade</label>
                    </div>
                    <div class="btn">
                    <button type="submit" name="subscrever">Subscrever</button>
                    </div> 
                    
                </form>
            </div>
        </section>
    </body>
</html>