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
    <title>Gerir Cursos</title>
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
   <div class="container dashboard-container" style="margin-top: 80px;">
        <div class="text-center">
            <h3>Cursos:</h3>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nome do Curso</th>
                        <th>Duração (horas)</th>
                        <th>Capacidade Máxima</th>
                        <th>Preço</th>
                        <th>Docente</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        
                        $sql = "SELECT c.*,u.nome AS nome_docente FROM curso c LEFT JOIN utilizador u ON c.id_docente = u.id_utilizador";
                        $resultado = mysqli_query($conn, $sql);
                        // Listar os cursos inscritos pelo aluno
                        if ($resultado && mysqli_num_rows($resultado) > 0) {
                            while ($row = mysqli_fetch_assoc($resultado)) {
                                echo "<tr>";
                                echo "<td>".$row['nome']."</td>";
                                echo "<td>".$row['duracao']."</td>";
                                echo "<td>".$row['capacidade_maxima']."</td>";
                                echo "<td>".$row['preco']."</td>";
                                echo "<td>".$row['nome_docente']."</td>";
                                echo "<td><a href='criar_curso.php?id_curso=" . $row['id_curso'] . "'>Editar</a></td>";
                                echo "<td><a href='eliminar_curso.php?id_curso=" . $row['id_curso'] . "'>Eliminar</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>Não existem cursos.</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="text-center">
            <a href="criar_curso.php" class="btn btn-primary">Criar Novo Curso</a>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
</body>
</html>