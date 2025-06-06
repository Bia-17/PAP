<?php
session_start();
require_once 'conectar.php';
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Plantas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/post.css">
    <link rel="stylesheet" href="css/barralado.css">
    <link rel="stylesheet" href="css/footer.css">
    <script src="https://kit.fontawesome.com/76ed8667ce.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
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
                    <a href="conta.html" class="link-nav">
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
        <?php

        require_once 'conectar.php';

        if (isset($_GET['Id']) && is_numeric($_GET['Id'])) {
            $Id_Posts = intval($_GET['Id']);

        $sql="SELECT * FROM blogue_posts WHERE Id_Posts=?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $Id_Posts);
        mysqli_stmt_execute($stmt);
        $posts_run = mysqli_stmt_get_result($stmt);

        if(mysqli_num_rows($posts_run) > 0)
                    {
                        $post = mysqli_fetch_assoc($posts_run);
                            ?>
                            <div class="post-detalhes">
                                <div class="titulo">
                                    <h1><?php echo $post['Título']; ?></h1>
                                </div>
                                <div class="data">
                                    <h2><?php echo date("d-m-Y", strtotime($post['Data_Criação'])); ?></h2>
                                </div>
                                <div class="imagem">
                                    <img src="<?php echo $post['Imagem']; ?>" alt="Imagem">
                                </div>
                                <div class="info">
                                <div class="desc">
                                <div class="social-icons-p">
                                    <a href="#"><i class="fa-brands fa-facebook"></i></a>
                                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                    <a href="#"><i class="fa-brands fa-pinterest"></i></a>
                                </div>
                                <div class="introducao fade-in">
                                    <p><?php echo $post['Descrição']; ?></p>
                                </div>
                                <div class="conteudo fade-in">
                                    <p><?php echo $post['Conteúdo']; ?></p>
                                </div>
                                <div class="conclusao fade-in">
                                    <p><?php echo $post['Conclusão']; ?></p>
                                </div>
                                </div>
                                </div>
                            </div>
                            <script src="js/scroll.js"></script>
                            <?php
                            }
                            else{
                                echo "Sem resultados";
                            }
                        }
                        ?>
                        <div class="linha">
                            <hr>
                            <a href="#" class="topo">Voltar ao topo</a>
                            <hr>
                        </div>
                        <div class="footer">
                            <div>
                                <h3>Sobre</h3>
                                <br><a href="#">Contactos</a>
                                <br><a href="sobre.html">Sobre Nós</a>
                                <br><a href="#">Blogue</a>
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
    </body>
</html>