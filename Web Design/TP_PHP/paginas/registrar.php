<?php
function test_input($data) {
    $data=trim($data);
    $data=stripslashes($data);
    $data=htmlspecialchars($data);
    return $data;
}

include '../basedados/basedados.h';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.min.css" media="screen">
    <title>Register</title>
</head>

<style>
    /* Estilos para centralizar o conteúdo */
    html, body {
        height: 100%;
    }
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color:#3aa7d0;
    }
    .register-container {
        max-width: 400px;
        width: 100%;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    .register-container > h2 {
        font-weight: bold;
        
    }

</style>

<body>
<div class="register-container">
        <h2 class="text-center">Registar</h2>
        <form action="#" method="post">
        <div class="form-group">
                <label for="email">Nome:</label>
                <input type="text" class="form-control" id="name" name="register_nome" placeholder="Digite seu nome" required >
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="text" class="form-control" id="email" name="register_email" placeholder="Digite seu e-mail" required >
            </div>
            <div class="form-group">
                <label for="data_nascimento">Data de Nascimento:</label>
                <input type="date" class="form-control" id="data" name="register_data" required>
            </div>
            <div class="form-group">
                <label for="password">Senha:</label>
                <input type="password" class="form-control" id="password" name="register_password" placeholder="Digite sua senha" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Registar</button>
        </form>
        <?php
        
        if(isset($_POST['register_nome']) && isset($_POST['register_email']) && isset($_POST['register_password']) && isset($_POST['register_data'])){
            $nome = test_input($_POST['register_nome']);
            $email = test_input($_POST['register_email']);
            $pass = test_input($_POST['register_password']);
            $data_nascimento = $_POST['register_data'];
            $nivel_acesso = 4;
            $query = "select email from utilizador where email = '$email'";

            $resultado = mysqli_query($conn,$query);

            if(mysqli_num_rows($resultado)>0){
                echo '<div class="text-center"><h5> E-mail já está registado!</h5></div>';
            } else {
                $insert = "insert into utilizador (nome, email, password, nivel_acesso,data_nascimento) values('$nome','$email',md5('$pass'),'$nivel_acesso',' $data_nascimento')";
                $validar = mysqli_query($conn,$insert);

                if($validar) {
                header("location: ./login.php");
                } else {
                    echo '<div class="text-center"><h5> Não foi possivel registrar!</h5></div>';
                }
            }
        }
        ?>
        </div>   
        
</body>
</html>