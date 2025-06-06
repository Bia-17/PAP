<?php
session_start();

// Verifica se o carrinho está vazio
if (!isset($_SESSION['carrinho']) || empty($_SESSION['carrinho'])) {
    echo "<p>O carrinho está vazio. <a href='plantas.php'>Voltar às compras</a></p>";
    exit();
}

$total = 0;
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/checkout.css">
    <link rel="Stylesheet" href="css/barralado.css">
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
<div class="container">
    <h2>Finalizar Compra</h2>

    <!-- Lista de plantas do Carrinho -->
    <div class="carrinho">
        <h3>Resumo do Pedido</h3>
        <?php foreach ($_SESSION['carrinho'] as $item):
            $subtotal = (float)$item['preco'] * (int)$item['quantidade'];
            $total += $subtotal;
            $imagens = explode(',', $item['imagem']);
            $primeiraImagem = $imagens[0];
        ?>
                <div class="item">
                    <img src="<?php echo $primeiraImagem; ?>" alt="Produto">
                <div>
                    <strong><?php echo $item['nome']; ?></strong> <br>
                    Quantidade: <?php echo $item['quantidade']; ?> <br>
                    Preço: €<?php echo number_format($item['preco'], 2); ?> <br>
                    Subtotal: €<?php echo number_format($subtotal, 2); ?> <br>
                    Cor: <?php echo $item['cor']; ?>
                </div>
            </div>
        <?php endforeach; ?>
        <h3>Total: €<?php echo number_format($total, 2); ?></h3>
    </div>

    <!-- Formulário de Checkout -->
    <form action="processar_pagamento.php" method="POST">
        <h3>Dados do Cliente</h3>
        <label>Nome Completo:</label>
        <input type="text" name="nome" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Morada:</label>
        <input type="text" name="morada" required>

        <label>Código Postal:</label>
        <input type="text" name="postal" required>

        <label>Telefone:</label>
        <div class="telefone-container">
            <span class="prefixo">+351</span>
            <input type="text" id="telefone" name="telefone" maxlength="9" pattern="[0-9]{9}" required placeholder="912345678">
        </div>
        
        <h3>Serviços Adicionais</h3>
        <label>
            <input type="checkbox" id="servico-plantacao" name="servico_plantacao" value="1">
            Serviço de entrega e plantação em casa (+€14.99)
        </label>
        <p class="descricao-servico">
            Este serviço inclui a entrega da planta na sua morada e a plantação no local escolhido, garantindo que tudo é feito corretamente e sem preocupações para si.
        </p>


        <h3>Método de Pagamento</h3>
        <div class="pagamento-opcoes">
            <label>
                <input type="radio" name="pagamento" value="mbway" required onclick="mostrarMBWay(true)">
                MB WAY
            </label>
            <label>
                <input type="radio" name="pagamento" value="transferencia" onclick="mostrarMBWay(false)">
                Transferência Bancária
            </label>
        </div>

        <div id="campo-mbway" style="display: none; margin-top: 10px;">
            <label>Número MB WAY:</label>
            <input type="text" id="numero-mbway" name="numero_mbway" maxlength="9" pattern="[0-9]{9}" placeholder="912345678">
        </div>

        <div id="campo-transferencia" style="display: none; margin-top: 10px;">
            <p><strong>Dados para Transferência:</strong></p><br>
            <p><strong>IBAN:</strong> PT50 3842 3423 9437 0003 9012 7</p>
            <p><strong>Titular:</strong> Sementes & Raízes</p>
            <p><strong>Banco:</strong> Montepio</p>
            <p>Após o pagamento, envie o comprovativo para: <strong>geral@sementesraizes.pt</strong></p>
        </div>


        <input type="hidden" name="total" value="<?php echo $total; ?>">

        <button type="submit" class="btn-finalizar">Finalizar Compra</button>
    </form>
</div>
</div>
<script>
        function mostrarMBWay(mostrarMBWay) {
            const campoMBWay = document.getElementById("campo-mbway");
            const campoTransferencia = document.getElementById("campo-transferencia");

            if (mostrarMBWay) {
                campoMBWay.style.display = "block";
                campoTransferencia.style.display = "none";
                document.getElementById("numero-mbway").setAttribute("required", "true");
            } else {
                campoMBWay.style.display = "none";
                document.getElementById("numero-mbway").removeAttribute("required");

                const transferenciaSelecionada = document.querySelector('input[name="pagamento"][value="transferencia"]').checked;
                if (transferenciaSelecionada) {
                    campoTransferencia.style.display = "block";
                } else {
                    campoTransferencia.style.display = "none";
                }
            }
        }


    document.getElementById("telefone").addEventListener("input", function (e) {
        this.value = this.value.replace(/\D/g, "");
    });

    document.querySelector("form").addEventListener("submit", function (e) {
        let telefone = document.getElementById("telefone").value;
        if (telefone.length !== 9) {
            alert("O número de telefone deve ter exatamente 9 dígitos!");
            e.preventDefault();
        }
    });

    const servicoCheckbox = document.getElementById('servico-plantacao');
    const totalElemento = document.querySelector('.carrinho h3:last-of-type');
    const inputTotal = document.querySelector('input[name="total"]');
    const precoServico = 14.99;
    let totalOriginal = <?php echo $total; ?>;

    servicoCheckbox.addEventListener('change', function () {
        let novoTotal = totalOriginal;
        if (this.checked) {
            novoTotal += precoServico;
        }
        totalElemento.textContent = "Total: €" + novoTotal.toFixed(2);
        inputTotal.value = novoTotal.toFixed(2);
    });

</script>
</body>
</html>