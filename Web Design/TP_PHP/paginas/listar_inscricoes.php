<?php

ob_start();
include "../basedados/basedados.h";
include 'navbar.php';
session_start();

if (!isset($_SESSION['estaLogado']) || $_SESSION['nivel_acesso'] != 2 && $_SESSION['nivel_acesso'] != 3) {
    header("Location: login.php");
    exit;
}
    $nome = $_SESSION['nome'];
    $id_curso = $_GET['id_curso'];

?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--link bootstrap-->
    <link rel="stylesheet" href="bootstrap.min.css" media="screen">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>

    <?php if ($_SESSION['nivel_acesso'] == 2) { ?>
        <title>Área do Docente</title>
    <?php } elseif ($_SESSION['nivel_acesso'] == 3) { ?>
        <title>Área do Administrador</title>
    <?php } ?>


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
           <h3>Inscrições:</h3>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nome do Candidato</th>
                        <th>E-mail</th>
                        <th>Data de nascimento</th>
                        <th>Data de inscrição</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $resultado;
                    if($_SESSION['nivel_acesso']==3){
                        $sql = "SELECT i.id_inscricao, u.nome, u.email, u.data_nascimento, i.data_inscricao,i.esta_ativa FROM inscricao i 
                                INNER JOIN utilizador u ON i.id_utilizador = u.id_utilizador
                                INNER JOIN curso c ON i.id_curso = c.id_curso
                                WHERE c.id_curso = '$id_curso'";

                        $resultado = mysqli_query($conn, $sql);
                        }
                    if($_SESSION['nivel_acesso']==2){
                        $sql = "SELECT i.id_inscricao, u.nome, u.email, u.data_nascimento, i.data_inscricao,i.esta_ativa FROM inscricao i 
                                INNER JOIN utilizador u ON i.id_utilizador = u.id_utilizador
                                INNER JOIN curso c ON i.id_curso = c.id_curso
                                WHERE c.id_curso = '$id_curso' AND c.id_docente = ".$_SESSION['id_utilizador']."";
                        $resultado = mysqli_query($conn, $sql);
                    }
                    // Listar os cursos para gerenciar inscrições
                    if ($resultado && mysqli_num_rows($resultado) > 0) {
                        while ($row = mysqli_fetch_assoc($resultado)) {
                            echo "<tr>";
                            echo "<td>".$row['nome']."</td>";
                            echo "<td>".$row['email']."</td>";
                            echo "<td>".$row['data_nascimento']."</td>";
                            echo "<td>".$row['data_inscricao']."</td>";
                            if($row['esta_ativa']==0){
                                echo '<td><a href="atualizar_inscricao.php?id_inscricao=' . $row['id_inscricao'] . '&id_curso='.$id_curso.'">Validar</a></td>';
                            } else{
                                echo '<td><a href="atualizar_inscricao.php?id_inscricao=' . $row['id_inscricao'] .  '&id_curso='.$id_curso. '">Desativar</a></td>';
                            }
                            echo '<td><a href="eliminar_inscricao.php?id_inscricao=' . $row['id_inscricao'] .'&id_curso='.$id_curso. '">Eliminar</a></td>';
                            echo "</tr>";
                        }
                    } else {
                            echo "<tr><td colspan='5'>Não há inscrições.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>