<?php
session_start();
require_once 'conectar.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $Id_Planta = intval($_GET['id']);
        } else {
            die("ID inválido");
        }

// Processar o envio da avaliação
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['review_texto']) && !empty($_POST['review_texto']) && isset($_POST['rating'])) {
    if (!isset($_SESSION['Id_Cliente'])) {
        die("Precisa de estar autenticado para enviar avaliações.");
    }
    $id_cliente = $_SESSION['Id_Cliente'];
    $review_texto = trim($_POST['review_texto']);
    $rating = intval($_POST['rating']);

    if ($rating < 1 || $rating > 5) {
        echo "<p>A nota de avaliação deve ser entre 1 e 5.</p>";
        exit();
    }

    $check_query = "SELECT * FROM reviews WHERE Id_Cliente = ? AND Id_Planta = ?";
    $check_stmt = mysqli_prepare($con, $check_query);
    mysqli_stmt_bind_param($check_stmt, "ii", $id_cliente, $Id_Planta);
    mysqli_stmt_execute($check_stmt);
    $check_result = mysqli_stmt_get_result($check_stmt);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<p>Já enviou uma avaliação para esta planta.</p>";
    } else {
        $r = "INSERT INTO reviews (Id_Cliente, Id_Planta, review_texto, rating, Data_Criação) VALUES (?, ?, ?, ?, NOW())";
        $stm = mysqli_prepare($con, $r);

        if ($stm) {
            mysqli_stmt_bind_param($stm, "iisi", $id_cliente, $Id_Planta, $review_texto, $rating);
            if (mysqli_stmt_execute($stm)) {
                header("Location: " . $_SERVER['REQUEST_URI']);
                exit();
            } else {
                echo "<p>Erro ao enviar a avaliação. Tente novamente. Erro SQL: " . mysqli_stmt_error($stm) . "</p>";
            }
        } else {
            echo "<p>Erro na preparação da consulta: " . mysqli_error($con) . "</p>";
        }
    }
}

?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Plantas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/planta.css">
    <link rel="stylesheet" href="css/barralado.css">
    <link rel="stylesheet" href="css/footer.css">
    <script src="https://kit.fontawesome.com/76ed8667ce.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
    let slideIndex = 0;
    const slides = document.querySelectorAll(".slide");

    function mostrarSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.remove("ativo");
            if (i === index) {
                slide.classList.add("ativo");
            }
        });
    }

    function mudarSlide(direcao) {
        slideIndex += direcao;
        if (slideIndex < 0) {
            slideIndex = slides.length - 1;
        } else if (slideIndex >= slides.length) {
            slideIndex = 0;
        }
        mostrarSlide(slideIndex);
    }

    mostrarSlide(slideIndex);

    const btnAnterior = document.querySelector('.carrossel-btn.anterior');
    const btnSeguinte = document.querySelector('.carrossel-btn.seguinte');

    if (btnAnterior && btnSeguinte) {
        btnAnterior.addEventListener('click', function() {
            mudarSlide(-1);
        });

        btnSeguinte.addEventListener('click', function() {
            mudarSlide(1);
        });
    }
});

</script>
<section id="pag1" class="pag1">
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
<?php

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $Id_Planta = intval($_GET['id']);

$sql="SELECT * FROM plantas WHERE Id_Planta=?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "i", $Id_Planta);
mysqli_stmt_execute($stmt);
$products_run = mysqli_stmt_get_result($stmt);

if(mysqli_num_rows($products_run) > 0)
            {
                $planta = mysqli_fetch_assoc($products_run);
                    ?>
                        <div class="planta-detalhes">
                        <?php
                        $imagens = explode(',', $planta['Imagem']);
                        ?>
                        <div class="imagem">
                            <div class="carrossel">
                                <?php foreach ($imagens as $index => $img): ?>
                                    <img src="<?php echo $img; ?>" class="slide <?php echo $index === 0 ? 'ativo' : ''; ?>" alt="Imagem da planta">
                                <?php endforeach; ?>
                                <button class="carrossel-btn anterior" onclick="mudarSlide(-1)">&#10094;</button>
                                <button class="carrossel-btn seguinte" onclick="mudarSlide(1)">&#10095;</button>
                            </div>
                        </div>
                        <div class="info">
                            <h1><?php echo $planta['Nome_Científico']; ?></h1>
                            <h2><?php echo $planta['Nome_Comum']; ?></h2>
                            <p class="preco">€<?php echo $planta['Preço']; ?></p>
                            <p class="desc"><?php echo $planta['Descrição']; ?></p>
                            <div class="opcoes">
                                <p>Escolha o tamanho da planta</p>
                                <button class="opcao"><?php echo $planta['Altura'] .' | '. $planta['Diâmetro']; ?></button>
                            </div>
                            <?php
                            $cores = explode(',', $planta['Cor']);
                            ?>
                            <form id="carrinho-form" method="POST" action="">
                            <div class="cores">
                                <p>Escolha a cor disponível:</p>
                                <form method="POST" action="">
                                    <div class="cores-opcoes">
                                        <?php foreach ($cores as $cor): ?>
                                            <button
                                                type="button"
                                                class="botao-cor"
                                                data-cor="<?php echo htmlspecialchars(trim($cor)); ?>"
                                                style="background-color: <?php echo htmlspecialchars(trim($cor)); ?>;">
                                                <?php echo htmlspecialchars(trim($cor)); ?>
                                            </button>
                                        <?php endforeach; ?>
                                    </div>
                            <input type="hidden" name="cor" id="cor" value="">
                            <div class="quant">
                                <p>Quantidade</p>
                                <button type="button" class="diminuir" onclick="alterarQuantidade(-1)">-</button>
                                    <span class="quantidade" id="quantidade">1</span>
                                <button type="button" class="aumentar" onclick="alterarQuantidade(1)">+</button>
                            </div>
                            </form>

                                <input type="hidden" name="quantidade" id="input-quantidade" value="1">
                                <?php if (isset($_SESSION['Id_Cliente'])): ?>
                                    <button type="submit" class="adicionar-carrinho">Adicionar ao carrinho</button>
                                <?php else: ?>
                                    <button type="button" class="adicionar-carrinho" disabled title="Precisa de iniciar sessão para adicionar ao carrinho">Adicionar ao carrinho</button>
                                <?php endif; ?>

                            </form>
                        </div>
                    </div>
                    <?php
    }
    else{
        echo "Sem resultados";
    }
}
?>

<script>
const botoesCor = document.querySelectorAll('.botao-cor');
botoesCor.forEach(button => {
    button.addEventListener('click', function() {
        botoesCor.forEach(btn => btn.classList.remove('selecionado'));

        this.classList.add('selecionado');

        const corSelecionada = this.getAttribute('data-cor');
        document.getElementById('cor').value = corSelecionada;
    });
});

document.getElementById("carrinho-form").addEventListener("submit", function(event) {
    event.preventDefault();

    let quantidade = document.getElementById("input-quantidade").value;
    let nome = "<?php echo addslashes($planta['Nome_Científico']); ?>";
    let preco = "<?php echo $planta['Preço']; ?>";
    let imagem = "<?php echo $planta['Imagem']; ?>";
    let cor = document.getElementById("cor").value;

    let dados = new FormData();
    dados.append("nome", nome);
    dados.append("preco", preco);
    dados.append("quantidade", quantidade);
    dados.append("imagem", imagem);
    dados.append("cor", cor);

    fetch("carrinho.php", {
        method: "POST",
        body: dados
    })
    .then(response => response.text())
    .then(data => {
        console.log("Resposta do servidor:", data);
        alert("Planta adicionada ao carrinho!");
    })
    .catch(error => console.error("Erro ao adicionar ao carrinho:", error));
});

function alterarQuantidade(valor){
    let quantidadeElemento=document.getElementById("quantidade");
    let inputQuantidade=document.getElementById("input-quantidade");
    let quantidade=parseInt(quantidadeElemento.textContent) + valor;

    if(quantidade<1) quantidade=1;
    quantidadeElemento.textContent=quantidade;
    inputQuantidade.value=quantidade;
}

</script>


</section>
<section id="pag2" class="pag2">
<div class="info-cuidados">
    <div class="caixa-cuidados">
        <h3>Luminosidade <i class="fa-solid fa-sun"></i></h3><br>
        <p class="luminosidade"><?php echo $planta['Luminosidade']; ?></p>
    </div>
    <div class="caixa-cuidados">
        <h3>Rega <i class="fa-solid fa-droplet"></i></h3><br>
        <p class="rega"><?php echo $planta['Rega']; ?></p>
    </div>
    <div class="caixa-cuidados">
        <h3>Clima <i class="fa-solid fa-cloud"></i></h3><br>
        <p class="clima"><?php echo $planta['Clima']; ?></p>
    </div>
</div>

<div class="caixa-reviews">
    <h3>Avaliações</h3>
    <div class="lista-reviews">
        <?php
        $re="SELECT r.review_texto, r.Data_Criação, r.rating, u.Nome AS Nome
                FROM reviews r 
                JOIN utilizadores u ON r.Id_Cliente = u.Id_Cliente 
                WHERE r.Id_Planta = ?
                ORDER BY r.Data_Criação DESC";
        $review = mysqli_prepare($con, $re);
        if (!$review) {
            die("Erro na preparação da consulta: " . mysqli_error($con));
        }

        if (!$con) {
            die("Erro na conexão com a base de dados: " . mysqli_connect_error());
        }

        mysqli_stmt_bind_param($review, "i", $Id_Planta);
        mysqli_stmt_execute($review);
        $reviews_run = mysqli_stmt_get_result($review);

        if(mysqli_num_rows($reviews_run) > 0) {
            while($row=mysqli_fetch_assoc($reviews_run)){
        ?>
        <div class="review_cliente">
            <p class="nome_review"><?php echo $row['Nome']; ?></p>
            <div class="rating">
            <?php
            $ratings = $row['rating'];

            for ($i = 1; $i <= 5; $i++) {
                if ($i <= $ratings) {
                    echo '<i class="fa-solid fa-star"></i>';
                } else {
                    echo '<i class="fa-regular fa-star"></i>';
                }
            }
            ?>
            </div>
            <p class="data"><?php echo date('Y-m-d', strtotime($row['Data_Criação'])); ?></p>
            <p class="texto_review"><?php echo $row['review_texto']; ?></p>
        </div>
        <?php
            } 
        } else {
            echo "<p>Sem avaliações para esta planta.</p>";
        }

        // Formulário de avaliação
        if (isset($_SESSION['Id_Cliente'])) {
        ?>
            <form method="POST" action="">
                <textarea name="review_texto" placeholder="Escreva a sua avaliação aqui..."></textarea>
                <div>
                    <label for="rating">Avaliação:</label>
                    <select name="rating" id="rating">
                        <option value="1">1 Estrela</option>
                        <option value="2">2 Estrelas</option>
                        <option value="3">3 Estrelas</option>
                        <option value="4">4 Estrelas</option>
                        <option value="5">5 Estrelas</option>
                    </select>
                </div>
                <button type="submit" class="add-reviews">Enviar</button>
            </form>
        <?php
        }
        ?>
    </div>
</div>

</section>
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
</body>