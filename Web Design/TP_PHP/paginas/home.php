<?php
include '../basedados/basedados.h';
include 'navbar.php';
session_start();

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <style>
        body {
            padding-top: 50px;
            background-color: #f0f6fc;
        }
        .jumbotron {
            background-image: url('main_banner.jpg');
            background-position: center;
            background-size: cover;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }
        .course-container {
            margin-top: 30px;
        }
        .course-container .thumbnail {
            border: none;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }
       
        .course-container .caption {
            padding: 20px;
            text-align: center;
        }
        .course-container h3 {
            font-size: 24px;
            color: #333;
        }
        .course-container p {
            font-size: 16px;
            color: #666;
        }
        .btn-details {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
        }
        
    </style>
</head>

<body>
    <?php exibirNavbar() ?>
    
    <div class="jumbotron">
        <div class="container">
            <h1>Bem-vindo à EstFormações</h1>
            <p>A número 1 em formações profissionais.</p>
        </div>
    </div>

    <div class="container course-container">
        <div class="text-center">
            <h1 class="display-4">Conheça nossos cursos</h1>
        </div>
        <hr>
        <div class="row">
            <?php 
                $sql = "SELECT * FROM curso";
                $result = mysqli_query($conn, $sql);
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="col-md-4">';
                        echo '<div class="thumbnail">';
                        echo '<div class="caption">';
                        echo '<h3>'.$row['nome'].'</h3>';
                        echo '<p>'.$row['descricao'].'</p>';
                        echo '<p><a href="curso.php?id_curso='.$row['id_curso'].'" class="btn btn-details" role="button">Mais detalhes</a></p>';
                        echo '</div></div></div>';
                    }
                }
            ?>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
</body>
</html>