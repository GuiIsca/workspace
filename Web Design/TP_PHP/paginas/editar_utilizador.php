<?php
ob_start();
session_start();
include "../basedados/basedados.h";
include 'navbar.php';

if (!isset($_SESSION['estaLogado']) || $_SESSION['nivel_acesso'] != 3) {
    header("Location: login.php");
    exit;
}
if (!isset($_GET['id_utilizador'])) {
    echo "Parâmetro id_utilizador não foi fornecido.";
    exit; 
}

$id_utilizador = $_GET['id_utilizador'];


$sql = "SELECT * FROM utilizador WHERE id_utilizador=$id_utilizador";

$resultado = mysqli_query($conn,$sql);

if($resultado && mysqli_num_rows($resultado)){
    while($row = mysqli_fetch_assoc($resultado)){
        $nome_utilizador = $row['nome'];
        $email_utilizador = $row['email'];
        $pass_utilizador = $row['password'];
        $data_nascimento_utilizador = $row['data_nascimento'];
        $nivel_acesso = $row['nivel_acesso'];
    }

} else {
    echo "erro ao deletar utilizador";
}

?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Dados Pessoais</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <style>
        body {
            background-color: #f3f3f3;
            padding-top: 50px;
        }
        .dashboard-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px auto;
            max-width: 600px;
            margin-top: 50px;
        }
        .dashboard-container h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .dados-pessoais {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php exibirNavbar() ?>
    <div class="container" >
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="dashboard-container">
                    <h1>Editar Dados Pessoais</h1>
                    <form action="" method="POST">
                        <div class='dados-pessoais'>
                            <div class="form-group">
                                <label for="">Nome:</label>
                                <input type="text" id="nome" name="user_nome" class="form-control" value="<?php echo $nome_utilizador; ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Email:</label>
                                <input type="email" id="email" name="user_email" class="form-control" value="<?php echo $email_utilizador; ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Data Nascimento:</label>
                                <input type="date" id="data_nasc" name="user_data_nascimento" class="form-control" value="<?php echo  $data_nascimento_utilizador; ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Password:</label>
                                <input type="password" id="data_nasc" name="user_pass" class="form-control" value="<?php echo  $pass_utilizador; ?>">
                            </div>
                            <div-form-group>
                                <label for="nivel_acesso">Nível de Acesso:</label>
                                    <select id="nivel_acesso" name="nivel_acesso" value="<?php echo $nivel_acesso ?>">
                                        <option value="4" <?php if($nivel_acesso==4) echo "selected";?>>Não validado</option>;
                                        <option value="1" <?php if($nivel_acesso==1) echo "selected";?>>Aluno</option>
                                        <option value="2" <?php if($nivel_acesso==2) echo "selected";?>>Docente</option>
                                        <option value="3" <?php if($nivel_acesso==3) echo "selected";?>>Administrador</option>
                                    </select><br><br>
                            </div-form-group>
                        </div>
                        <div class="form-group logout-btn">
                            <input type="submit" value="Salvar" class="btn btn-primary">
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php

        if(isset($_POST['user_nome']) || isset($_POST['user_email']) || isset($_POST['user_data_nascimento']) || isset($_POST['user_pass']) || isset($_POST['nivel_acesso'])){
            $novo_nome = $_POST['user_nome'];
            $novo_email = $_POST['user_email'];
            $novo_data_nascimento = $_POST['user_data_nascimento'];
            $novo_pass = $_POST['user_pass'] ;
            $novo_nivel_acesso = $_POST['nivel_acesso'];

            if($novo_pass == $pass_utilizador){
                $sql = "UPDATE utilizador SET nome = '$novo_nome', email = '$novo_email', data_nascimento = '$novo_data_nascimento', nivel_acesso = '$novo_nivel_acesso' WHERE id_utilizador = '$id_utilizador'";
            } else {
                $sql = "UPDATE utilizador SET nome = '$novo_nome', email = '$novo_email', data_nascimento = '$novo_data_nascimento', nivel_acesso = '$novo_nivel_acesso', password = md5('$novo_pass') WHERE id_utilizador = '$id_utilizador'";
            }

            $resultado = mysqli_query($conn,$sql);
            if($resultado && mysqli_affected_rows($conn)>0){
                echo "<script>alert('Alteração realizada com sucesso')</script>";
                echo "<script>window.location.href = './gerir_utilizadores.php';</script>";
            } 

        }
            
    ?>

    <!-- Bootstrap JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
</body>
</html>