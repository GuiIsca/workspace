<?php
ob_start();
session_start();
include "../basedados/basedados.h";
include 'navbar.php';

if (!isset($_SESSION['estaLogado']) || $_SESSION['nivel_acesso'] != 3) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id_curso'])) {
    $id_curso = $_GET['id_curso'];
    $sql = "SELECT * FROM curso WHERE id_curso = '$id_curso'";
    $resultado = mysqli_query($conn, $sql);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $row = mysqli_fetch_assoc($resultado);
        $nome = $row['nome'];
        $descricao = $row['descricao'];
        $capacidade_maxima = $row['capacidade_maxima'];
        $idade_maxima = $row['idade_maxima'];
        $duracao =  $row['duracao'];
        $preco = $row['preco'];
        $id_docente = $row['id_docente'];
    } else{
        echo "Não existe nenhum curso correspondente a este id";
    }
}

?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerir Curso</title>
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
                    <h1>Curso</h1>
                    <form action="" method="POST">
                        <div class='dados-curso'>
                            <div class="form-group">
                                <label for="nome">Nome do Curso:</label>
                                <input type="text" class="form-control" id="nome" name="nome" value="<?php if(isset($nome)) echo $nome; ?>"required>
                            </div>
                             <div class="form-group">
                                <label for="descricao">Descrição do Curso:</label>
                                <textarea class="form-control" id="descricao" name="descricao" required><?php if(isset($descricao)) echo $descricao; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="capacidade_maxima">Capacidade Máxima de Alunos:</label>
                                <input type="number" class="form-control" id="capacidade_maxima" value="<?php if(isset($capacidade_maxima)) echo $capacidade_maxima; ?>" name="capacidade_maxima" required>
                            </div>
                            <div class="form-group">
                                <label for="idade_maxima">Idade Máxima:</label>
                                <input type="number" class="form-control" id="idade_maxima" name="idade_maxima"  value="<?php if(isset($idade_maxima)) echo $idade_maxima; ?>"required>
                            </div>
                            <div class="form-group">
                                <label for="preco">Preço do Curso:</label>
                                <input type="number" class="form-control" id="preco" value="<?php if(isset($preco)) echo $preco; ?>"  name="preco" step="0.01" required>
                            </div>
                            <div class="form-group">
                                <label for="duracao">Duração do Curso (horas):</label>
                                <input type="number" class="form-control" id="duracao" name="duracao" value="<?php if(isset($duracao)) echo $duracao; ?>"required>
                            </div>

                            <div class="form-group">
                                <label for="docente">Docente do Curso:</label>
                                <select class="form-control" id="docente" name="id_docente" required>
                                    <?php
                                    $sql = "SELECT * FROM utilizador WHERE nivel_acesso=2";

                                    $resultado = mysqli_query($conn,$sql);
                                    
                                    if($resultado && mysqli_num_rows($resultado)){
                                        while($row = mysqli_fetch_assoc($resultado)){
                                            echo "<option value='" . $row['id_utilizador'] . "'>" . $row['nome'] . "</option>";
                                        }
                                    
                                    } else {
                                        echo "<option value=''>Nenhum coordenador disponível</option>";
                                    }
                                    
                                    ?>
                                </select>
                            </div>
                            
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
        if (isset($_POST['nome'])||isset($_POST['descricao'])||isset($_POST['capacidade_maxima'])||isset($_POST['idade_maxima'])||
        isset($_POST['preco'])||isset($_POST['id_docente'])) {
            
            $nome = $_POST['nome'];
            $descricao = $_POST['descricao'];
            $capacidade_maxima = $_POST['capacidade_maxima'];
            $idade_maxima = $_POST['idade_maxima'];
            $duracao = $_POST['duracao'];
            $preco = $_POST['preco'];
            $id_docente = $_POST['id_docente'];

            // Verifica se o ID do curso já existe
            if (isset($id_curso)) {
                // Atualizar curso existente
                $sql = "UPDATE curso SET nome = duracao='$duracao','$nome', descricao = '$descricao', capacidade_maxima = $capacidade_maxima,
                        idade_maxima = $idade_maxima, preco = $preco, id_docente = $id_docente WHERE id_curso = $id_curso";
            } else {
                // Inserir novo curso
                $sql = "INSERT INTO curso (nome, descricao, capacidade_maxima, duracao,idade_maxima, preco, id_docente) 
                        VALUES ('$nome', '$descricao', '$capacidade_maxima', '$duracao','$idade_maxima', '$preco', '$id_docente')";
            }

            // Executar a consulta SQL
            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('Curso salvo com sucesso!')</script>";
                echo "<script>window.location.href = './gerir_curso.php';</script>";
            } else {
                echo "Erro ao salvar o curso: " . mysqli_error($conn);
            }
        }
?>
    

      

    <!-- Bootstrap JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
</body>
</html>