<?php
include '../basedados/basedados.h';
include 'navbar.php';
session_start();

if(!isset($_GET['id_curso'])){
    header("location: ./home.php");
}
$id_curso=$_GET['id_curso'];


?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscrição</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap.min.css">
    <style>
        body {
            padding-top: 80px; 
            background-color: #f8f9fa; 
        }

        .container {
            max-width: 800px; 
            margin: auto;
            background-color: #fff; 
            padding: 30px;
            border-radius: 10px; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
        }

        .curso-info {
            margin-bottom: 30px;
        }

        .curso-info h1 {
            color: #007bff; 
        }

        .curso-info p {
            font-size: 18px;
        }

        .btn-inscrever {
            font-size: 1.5rem;
            padding: 15px 40px;
            border-radius: 25px;
            background-color: #007bff;
            border: none;
            color: #fff;
        }

        
    </style>
</head>

<body>
    <?php exibirNavbar(); ?>

    <div class="container">
        <div class="curso-info text-center">
            <?php
                $sql = "SELECT * FROM curso WHERE id_curso = $id_curso";

                $result=mysqli_query($conn,$sql);

                if($result && mysqli_num_rows($result)>0){
                    $row = mysqli_fetch_assoc($result);
                    $nome = $row['nome'];
                    $descricao = $row['descricao'];
                    $duracao = $row['duracao'];
                    $preco = $row['preco'];
                    $capacidade_maxima = $row['capacidade_maxima'];
                    $idade_maxima = $row['idade_maxima'];
            ?>
                <h1><?php echo $nome; ?></h1>
                <p class="lead"><?php echo $descricao; ?></p>
                <p><strong>Duração:</strong> <?php echo $duracao; ?> horas</p>
                <p><strong>Preço:</strong> <?php echo $preco; ?>€</p>
        </div>
        <div class='text-center'>
            <?php
                    if($capacidade_maxima==0){
                        echo  "<p class='lead'>Infelizmente esta formação atingiu a capacidade maxima de inscrições.</p>";
                    }else{
                        if(isset($_SESSION['id_utilizador'])){
                            $sql ="SELECT * FROM inscricao WHERE id_curso = $id_curso AND id_utilizador = ".$_SESSION['id_utilizador']. "";
                            $result = mysqli_query($conn, $sql);
        
                            if ( mysqli_num_rows($result) > 0) {
                                echo  "<p class='lead'>Você ja se encontra inscrito nesta formação.</p>";
                                exit;
                            } 
                        } 
                            echo '<a href="inscricao.php?id_curso=' . $id_curso . '&idade_maxima= '.$idade_maxima.'" class="btn btn-inscrever">Inscreva-se Agora!</a>'; 
                    }
                       
                }
                    
                
            ?>
      
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
</body>

</html>
