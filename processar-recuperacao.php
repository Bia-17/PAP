<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);

    $email_existe = true;

    if ($email_existe) {
        $token = bin2hex(random_bytes(16));

        $reset_link = "https://localhost/pap/reset-password.php?token=$token";

        $assunto = "Recuperação de palavra-passe";
        $mensagem = "Olá,\n\nRecebemos um pedido para redefinir a tua palavra-passe.\n";
        $mensagem .= "Clica no link abaixo para criar uma nova palavra-passe:\n\n";
        $mensagem .= "$reset_link\n\n";
        $mensagem .= "Se não fizeste este pedido, ignora este email.\n\nCumprimentos,\nA equipa.";

        $headers = "From: no-reply@sementesraizes.com\r\n";
        $headers .= "Reply-To: no-reply@sementesraizes.com\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        if (mail($email, $assunto, $mensagem, $headers)) {
            echo "<p>Email de recuperação enviado para <strong>$email</strong>. Verifica a tua caixa de entrada.</p>";
        } else {
            echo "<p>Erro ao enviar o email. Por favor, tenta novamente mais tarde.</p>";
        }
    } else {
        echo "<p>Se o email estiver registado, vais receber instruções para redefinir a palavra-passe.</p>";
    }
} else {
    header("Location: recuperar-password.php");
    exit;
}
?>
