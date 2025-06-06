<?php
include 'conectar.php';

if(isset($_POST['criar-conta'])){
    $nome = $_POST['nome'];
    $email = $_POST['email-registro'];
    $password = $_POST['password-registro'];

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $checkEmail = "SELECT * FROM utilizadores WHERE Email='$email'";
    $result = $con->query($checkEmail);
    if($result->num_rows > 0){
        echo "Já existe uma conta com esse email!";
    } else {
        $insertQuery = "INSERT INTO utilizadores(Nome,Email,password_u) VALUES('$nome','$email','$password_hash')";
        if($con->query($insertQuery) === TRUE){
            $_SESSION['msg_sucesso'] = "Conta criada com sucesso!";
            header("location: pagina.php"); 
        } else {
            echo "Erro: " . $con->error;
        }
    }
}

if(isset($_POST['entrar'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM utilizadores WHERE Email='$email'";
    $result = $con->query($sql);

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        
        if(password_verify($password, $row['password_u'])){
            session_start();
            $_SESSION['Email'] = $row['Email'];
            header("Location: pagina.php");
            exit();
        } else {
            echo "Email ou palavra-passe incorretos.";
        }
    } else {
        echo "Email ou palavra-passe incorretos.";
    }
}
?>
