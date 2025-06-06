    <?php
    session_start();

    if(!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho']=[];
    }

    //adicionar plantas

    if($_SERVER["REQUEST_METHOD"]=="POST") {
        $nome=$_POST["nome"] ?? "";
        $preco=$_POST["preco"] ?? "";
        $quantidade=$_POST["quantidade"] ?? 1;
        $imagem=$_POST["imagem"] ?? "";
        $cor = $_POST["cor"] ?? "";

        if($nome && $preco){
            $_SESSION['carrinho'][]=[
            "nome"=>$nome,
            "preco"=>$preco,
            "quantidade"=>$quantidade,
            "imagem"=>$imagem,
            "cor"=>$cor
            ];
        }
    }

    //Remover plantas

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["remover"])) {
        $indice = filter_var($_POST["remover"], FILTER_VALIDATE_INT);
        if ($indice !== false && isset($_SESSION['carrinho'][$indice])) {
            array_splice($_SESSION['carrinho'], $indice, 1);
        }
        header("Location: carrinho.php");
        exit();
    }

    ?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Carrinho de Compras</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/carrinho.css">
    <link rel="stylesheet" href="css/barralado.css">
    <script src="https://kit.fontawesome.com/76ed8667ce.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
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
        <div class="container-principal">
        <div class="carrinho-container">
            <h2>Carrinho de Compras</h2>

        <div id="carrinho">

        <?php

        //Mostrar plantas

        if(!empty($_SESSION['carrinho'])){
            $total=0;
            foreach($_SESSION['carrinho'] as $i=>$item){
                $subtotal = (float)$item['preco'] * (int)$item['quantidade'];
                $total += $subtotal;
                $imagens = explode(',', $item['imagem']);
                $primeiraImagem = $imagens[0];
                echo "
                <div class='carrinho-item'>
                        <img src='" . $primeiraImagem . "' alt='Produto'>
                    <div class='detalhes'>
                        <span>
                            <strong>{$item['nome']}</strong>
                            <br>Quantidade: {$item['quantidade']}
                            <br>Preço: €{$item['preco']}
                            <br>Cor: {$item['cor']}
                        </span>
                            <form method='POST' style='display:inline'>
                                <input type='hidden' name='remover' value='{$i}'>
                                <button type='submit' class='remover-btn'>Remover</button>
                            </form>
                        </div>
                    </div>";
            }
            echo "<div class='total'>Total: €" . number_format($total, 2) . "</div>";
            ?>
            <form id="finalizar-compra" method="POST" action="checkout.php">
                <input type="hidden" name="total" value="<?php echo number_format($total, 2); ?>">
                <button type="submit" class="checkout-btn">Finalizar Compra</button>
            </form>
            <?php
        } else {
            echo "<p>O carrinho está vazio.</p>";
        }
        ?>
        </div>
    </div>
</div>

<script>

document.getElementById("finalizar-compra").addEventListener("submit", function(event) {
    event.preventDefault();

    let quantidade = document.getElementById("input-quantidade").value;
    let nome = "<?php echo addslashes($planta['Nome_Científico']); ?>";
    let preco = "<?php echo $planta['Preço']; ?>";
    let imagem = "<?php echo $planta['Imagem']; ?>";

    let dados = new FormData();
    dados.append("nome", nome);
    dados.append("preco", preco);
    dados.append("quantidade", quantidade);
    dados.append("imagem", imagem);

    fetch("checkout.php", {
        method: "POST",
        body: dados
    })
});

$quantidade = isset($_POST["quantidade"]) ? (int) $_POST["quantidade"] : 1;

//remover

function removerItem(botao) {
    const indice = botao.getAttribute("data-indice");

    let dados = new FormData();
    dados.append("remover", indice);

    fetch("carrinho.php", {
        method: "POST",
        body: dados
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            atualizarCarrinho();
        } else {
            console.error("Erro ao remover item do carrinho.");
        }
    })
    .catch(error => console.error("Erro ao comunicar com o servidor:", error));
}

function atualizarCarrinho() {
    fetch("carrinho.php")
    .then(response => response.text())
    .then(data => {
        document.getElementById("carrinho").innerHTML = data;
    })
    .catch(error => console.error("Erro ao carregar o carrinho:", error));
}


document.getElementById("carrinho-form").addEventListener("submit", function(event) {
    event.preventDefault();

    let quantidade = document.getElementById("input-quantidade").value;
    let nome="<?php echo $planta['Nome_Científico']; ?>";
    let preco="<?php echo $planta['Preço']; ?>";
    let imagem="<?php echo $planta['Imagem']; ?>";

    let dados=new FormData();
    dados.append("nome", nome);
    dados.append("preco", preco);
    dados.append("quantidade", quantidade);
    dados.append("imagem", imagem);

    console.log("Quantidade enviada:", quantidade);

    fetch("carrinho.php", {
        method: "POST",
        body: dados
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
        alert("Planta adicionada ao carrinho!");
        atualizarCarrinho();
    })
    .catch(error => console.error("Erro:", error));
});

</script>
</body>
</html>