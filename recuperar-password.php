<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Palavra-passe</title>
    <link rel="stylesheet" href="css/conta.css">
</head>
<body>
    <main class="conteudo-principal">
        <div class="container">
            <h2>Recuperar Palavra-passe</h2>
            <p>Introduz o teu email para receberes instruções de recuperação.</p>
            <form action="processar-recuperacao.php" method="POST">
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="O teu email" required>
                </div>
                <button type="submit" class="btn">Enviar</button>
            </form>
        </div>
    </main>
</body>
</html>
