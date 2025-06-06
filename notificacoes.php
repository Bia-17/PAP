<?php
require_once "conectar.php";

$stmt = $con->prepare("SELECT Email FROM utilizadores WHERE Notificacoes_Email = 1");
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $email_destino = $row['Email'];
    $assunto = "Atualização do seu pedido";
    $mensagem = "O seu pedido foi atualizado!";
    $headers = "From: noreply@sementesraizes.com";

    mail($email_destino, $assunto, $mensagem, $headers);
}

$stmt->close();
$con->close();

echo "Notificações enviadas com sucesso!";
?>
