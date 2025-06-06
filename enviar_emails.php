<?php
echo "O arquivo PHP está funcionando!";
ini_set('display_errors', 1); 
ini_set('log_errors', 1);  
error_reporting(E_ALL); 

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = htmlspecialchars($_POST['email']);
    $questao = htmlspecialchars($_POST['questao']);
    $assunto = htmlspecialchars($_POST['assunto']);
    $nome = htmlspecialchars($_POST['nome']);

    echo "Email: " . $email . "<br>";
    echo "Questão: " . $questao . "<br>";

    if (!empty($email) && !empty($questao)) {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; 
            $mail->SMTPAuth   = true;        
            $mail->Username   = 'beatriz.detrigo@gmail.com'; 
            $mail->Password   = 'hwkg ambf rexq jfbn'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;     

            $mail->setFrom($email, $nome); 
            $mail->addAddress('beatriz.detrigo@gmail.com', 'Naturalis');
            $mail->addReplyTo($email, $nome);

            $mail->isHTML(true); 
            $mail->Subject = "{$assunto}"; 
            $mail->Body    = "
                <h2>Nova questão recebida</h2>
                <p><strong>Nome:</strong>{$nome}</p>
                <p><strong>Email do remetente:</strong> {$email}</p>
                <p><strong>Mensagem:</strong><br>{$questao}</p>
            ";
            $mail->AltBody = "Nova questão recebida\n\nEmail: {$email}\n\nMensagem:\n{$questao}"; 


            $mail->send();
            echo "<script>alert('Email enviado com sucesso!'); window.location.href='FAQ.html';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Erro ao enviar o email: {$mail->ErrorInfo}'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Por favor, preencha todos os campos.'); window.history.back();</script>";
    }
}
?>
