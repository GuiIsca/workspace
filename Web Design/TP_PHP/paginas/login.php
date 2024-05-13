<?php
ob_start();
include "../basedados/basedados.h";
session_start();
if(isset($_SESSION['estaLogado']) && $_SESSION['estaLogado']){
    header("location: ./home.php");
} 
?>


<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap.min.css" media="screen">
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
    .login-container {
        max-width: 400px;
        width: 100%;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    .login-container > h2 {
        font-weight: bold;
        
    }

</style>
<body>
    <div class="login-container">
        <h2 class="text-center">Login</h2>
        <form action="#" method="post">
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="text" class="form-control" id="email" name="user_email" placeholder="Digite seu e-mail" required >
            </div>
            <div class="form-group">
                <label for="password">Senha:</label>
                <input type="password" class="form-control" id="password" name="user_password" placeholder="Digite sua senha" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Entrar</button>
            <p class="text-center" style="margin-top: 10px;"><a href="registrar.php">Registe-se</a></p>
        </form>
        <p class="text-center" style="margin-top: 10px;"><a href="#">Esqueceu sua senha?</a></p>
    <?php
       
       //verificar se os dados foram inseridos
        if(isset($_POST['user_email']) && isset ($_POST['user_password'])){
            $email = $_POST['user_email'];
            $password = $_POST['user_password']; 
            $query = "select * from utilizador where email = '$email' and password = md5('$password')";

            $resultado = mysqli_query($conn,$query);
       
            //verificar se foi retornado algum resultado
            if(mysqli_num_rows($resultado)>0){
                $dados_user = mysqli_fetch_assoc($resultado);
                
                //caso o nivel de acesso seja 4(não validade) ou 5(apagado)
                if($dados_user['nivel_acesso']==4 || $dados_user['nivel_acesso']==5 ){
                    echo '<div class="text-center"><h5> Aguarde até que um administrador valide o teu acesso </h5></div>'; 
                } else{
                    $_SESSION['id_utilizador'] = $dados_user['id_utilizador'];
                    $_SESSION['nome'] = $dados_user['nome'];
                    $_SESSION['email'] = $dados_user['email'];
                    $_SESSION['nivel_acesso'] = $dados_user['nivel_acesso'];
                    $_SESSION['data_nascimento'] = $dados_user['data_nascimento'];
                    $_SESSION['estaLogado'] = true;

                    header("location: ./pagPessoal.php");
                }
            } else {
                echo '<div class="text-center"><h5> E-mail e/ou password inválidos!</h5></div>'; //caso não retorne nenhum resultado
            }
        }

    ?>
    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>

</html>