<?php
file_put_contents("log.txt", "POST: " . print_r($_POST, true), FILE_APPEND);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['entrar'])) {
    include("conectar.php");

    $email = mysqli_real_escape_string($con, $_POST['email']);
    $senha = $_POST['password'];

    $query = "SELECT * FROM utilizadores WHERE Email = ?";
    $stmt = $con->prepare($query);

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($senha, $user['password_u'])) {
                $_SESSION['Id_Cliente'] = $user['Id_Cliente'];
                $_SESSION['Nome'] = $user['Nome'];
                $_SESSION['Email'] = $email;
                $_SESSION['cargos'] = $user['cargos'];

                $_SESSION['msg_sucesso'] = "Sessão iniciada com sucesso!";

                if ($user['cargos'] === 'admin') {
                    header("Location: /PAP/BackOffice/backoffice-index.php");
                } else {
                    header("Location: pagina.php");
                }
                exit();
            } else {
                echo "Senha incorreta.";
            }
        } else {
            echo "Email não encontrado.";
        }

        $stmt->close();
    } else {
        echo "Erro na preparação da consulta.";
    }
}
?>
