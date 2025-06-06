<?php
session_start();

if (isset($_SESSION['Email'])) {
    header("Location: pagina.php");
    exit();
}
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="paginicial.css">
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/barralado.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login e Registro</title>
        <link rel="stylesheet" href="css/conta.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <script src="https://kit.fontawesome.com/76ed8667ce.js" crossorigin="anonymous"></script>
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
            <main class="conteudo-principal">
            <div class="container">
                <div class="botoes-cima">
                    <button id="entrar-tab" class="tab ativa">Entrar</button>
                    <button id="registro-tab" class="tab">Criar Conta</button>
                </div>
                <form id="entrar-form" class="form ativa" action="login.php" method="POST">
                    <div class="input-group">
                        <label for="email-login">Email</label>
                        <input type="email" name="email" id="email-login" placeholder="Email" required>
                    </div>
                    <div class="input-group">
                        <label for="password-login">Password</label>
                        <input type="password" name="password" id="password-login" placeholder="Password" required>
                    </div>
                    <a href="recuperar-password.php" class="forgot-password">Esqueceu-se da palavra-passe?</a>
                    <button type="submit" class="btn" name="entrar">Entrar</button>
                </form>
                <form method="post" action="registro.php" id="registro-form" class="form">
                    <div class="input-group">
                        <label for="nome-registro">Nome</label>
                        <input type="text" id="nome-registro" name="nome" placeholder="Nome" required>
                    </div>
                    <div class="input-group">
                        <label for="telemovel">Telemóvel (Opcional)</label>
                        <input type="tel" id="telemovel" name="telemovel" placeholder="Telemóvel">
                    </div>
                    <div class="input-group">
                        <label for="morada">Morada (Opcional)</label>
                        <input type="text" id="morada" name="morada" placeholder="Morada">
                    </div>
                    <div class="input-group">
                        <label for="email-registro">Email</label>
                        <input type="email" id="email-registro" name="email-registro" placeholder="Email" required>
                    </div>
                    <div class="input-group">
                        <label for="password-registro">Password</label>
                        <input type="password" id="password-registro" name="password-registro" placeholder="Password" required>
                    </div>
                    <div class="input-group">
                        <label for="password-registro-conf">Confirmar Password</label>
                        <input type="password" id="password-registro-conf" name="password-registro-conf" placeholder="Confirmar Password" required>
                    </div>
                    <button type="submit" class="btn" name="criar-conta">Criar Conta</button>
                </form>
            </div>
            <script src="js/conta.js"></script>
        </main>
    </body>
</html>