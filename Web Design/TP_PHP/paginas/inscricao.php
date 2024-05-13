<?php
include '../basedados/basedados.h';
session_start();

if (!isset($_SESSION['estaLogado']) || !$_SESSION['estaLogado']) {
    echo "<script>alert('Por favor, faça login ou registe-se para poder se inscrever a esta formação.')</script>";
    echo "<script>window.location.href = './login.php';</script>";
    exit; 
}


if (!isset($_SESSION['data_nascimento']) || !isset($_GET['idade_maxima'])) {
    echo "Informações de idade não disponíveis.";
    exit; 
}

$id_curso=$_GET['id_curso'];
$id_utilizador = $_SESSION['id_utilizador'];



$idade_maxima = $_GET['idade_maxima'];
$data_nascimento = $_SESSION['data_nascimento'];

// Criar objetos DateTime para a data de nascimento e a data de hoje
$data_nascimento = new DateTime($data_nascimento);
$data_hoje = new DateTime();

// Calcular a idade do utilizador
$idade = $data_hoje->diff($data_nascimento)->y;

// Verificar se a idade é menor ou igual à idade máxima permitida pelo curso
if ($idade >= 18 && $idade <= $idade_maxima) {
    // Consultar a capacidade máxima atual do curso
    $sql_capacidade = "SELECT capacidade_maxima FROM curso WHERE id_curso = $id_curso";
    $result_capacidade = mysqli_query($conn, $sql_capacidade);

    if ($result_capacidade) {
        $row = mysqli_fetch_assoc($result_capacidade);
        $capacidade_maxima_atual = $row['capacidade_maxima'];

        // Verificar se ainda há capacidade disponível para uma nova inscrição
        if ($capacidade_maxima_atual > 0) {
            // Realizar a inserção da nova inscrição na tabela inscricao
            $sql_inscricao = "INSERT INTO inscricao (id_utilizador, id_curso, data_inscricao) VALUES ('$id_utilizador', '$id_curso',NOW() )";

            if (mysqli_query($conn, $sql_inscricao)) {
                $nova_capacidade_maxima = $capacidade_maxima_atual - 1;
                $sql_atualiza_capacidade = "UPDATE curso SET capacidade_maxima = $nova_capacidade_maxima WHERE id_curso = $id_curso";
                mysqli_query($conn, $sql_atualiza_capacidade);

                echo "<script>alert('Inscrição realizada com sucesso!')</script>";
                echo "<script>window.location.href = './pagAluno.php';</script>";
              
            } else {
                echo "Erro ao realizar inscrição " ;
                
            }
        } else {
            echo "<script>alert('Capacidade máxima de inscrições atingida para este curso.')</script>";
        }
    } else {
        echo "Erro ao obter a capacidade máxima do curso" ;
    }
} else {
    echo "<script>alert('Desculpe, você não está dentro da idade permitida para se inscrever.')</script>";
}
?>