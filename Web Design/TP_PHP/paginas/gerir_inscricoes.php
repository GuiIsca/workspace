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
            <?php if ($_SESSION['nivel_acesso'] == 2) { ?>
                <h1 class="display-3">Bem-vindo à Área do Docente, <?php echo $_SESSION['nome']; ?>!</h1>
                <h3>Cursos lecionados:</h3>
            <?php } elseif ($_SESSION['nivel_acesso'] == 3) { ?>
                <h1 class="display-3">Bem-vindo à Área do Administrador, <?php echo $_SESSION['nome']; ?>!</h1>
                <h3>Gerenciar inscrições:</h3>
            <?php } ?>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nome do Curso</th>
                        <th>Candidatos Inscritos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $resultado;
                    if($_SESSION['nivel_acesso']==3){
                        $sql = "SELECT c.id_curso,c.nome AS nome_curso,  
                            (SELECT COUNT(*) FROM inscricao i WHERE c.id_curso = i.id_curso) AS total_inscritos
                            FROM curso c";
                            
                        $resultado = mysqli_query($conn, $sql);
                        }
                    if($_SESSION['nivel_acesso']==2){
                        $sql = "SELECT c.id_curso, c.nome AS nome_curso,  
                               (SELECT COUNT(*) FROM inscricao i WHERE c.id_curso = i.id_curso) AS total_inscritos
                               FROM curso c WHERE id_docente = ".$_SESSION['id_utilizador']."";
                               
                        $resultado = mysqli_query($conn, $sql);
                    }
                    // Listar os cursos para gerenciar inscrições
                    if ($resultado && mysqli_num_rows($resultado) > 0) {
                        while ($row = mysqli_fetch_assoc($resultado)) {
                            echo "<tr>";
                            echo "<td>".$row['nome_curso']."</td>";
                            echo "<td>".$row['total_inscritos']."</td>";
                            echo '<td><a href="listar_inscricoes.php?id_curso=' . $row['id_curso'] . '">Exibir listagem</a></td>';
                            echo "</tr>";
                        }
                    } else {
                        if ($_SESSION['nivel_acesso'] == 2) {
                            echo "<tr><td colspan='4'>Você ainda não leciona nenhum curso.</td></tr>";
                        } 
                        if ($_SESSION['nivel_acesso'] == 3) {
                            echo "<tr><td colspan='5'>Não há cursos para gerenciar inscrições.</td></tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>