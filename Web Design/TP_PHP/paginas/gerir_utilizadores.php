<?php

ob_start();
include "../basedados/basedados.h";
include 'navbar.php';
session_start();

if (!isset($_SESSION['estaLogado']) || $_SESSION['nivel_acesso'] != 3) {
    header("Location: login.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--link bootstrap-->
    <link rel="stylesheet" href="bootstrap.min.css" media="screen">   
    <title>Utilizadores</title>
    

</head>
<style>
     .dashboard-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px auto;
            
        }
    
</style>

<body>
    <?php exibirNavbar() ?>
   <div class="container dashboard-container" style="margin-top: 60px;">
        <div class="text-center">
           <h3>Utilizadores:</h3>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                  
                    $resultado;
                    $sql = "SELECT * FROM utilizador";

                    $resultado = mysqli_query($conn,$sql);

                    // Listar os cursos para gerenciar inscrições
                    if ($resultado && mysqli_num_rows($resultado) > 0) {
                        while ($row = mysqli_fetch_assoc($resultado)) {
                            echo "<tr>";
                            echo "<td>".$row['nome']."</td>";
                            echo "<td>".$row['email']."</td>";
                            echo '<td><a href="editar_utilizador.php?id_utilizador=' . $row['id_utilizador'] . '">Editar</a></td>';
                            echo '<td><a href="eliminar_utilizador.php?id_utilizador=' . $row['id_utilizador'] . '">Eliminar</a></td>';
                            echo "</tr>";
                        }
                    } else {
                            echo "<tr><td colspan='5'>Não há utilizadores.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
</body>
</html>