<?php
include "../basedados/basedados.h";
session_start();
if(!isset($_SESSION['estaLogado']) || !$_SESSION['estaLogado'] || $_SESSION['nivel_acesso']==4  || $_SESSION['nivel_acesso']==5){
    header("location: ./login.php");
    exit;
}

if (isset($_GET['id_inscricao']) && isset($_GET['id_curso'])) {
    $id_inscricao = $_GET['id_inscricao'];
    $id_curso = $_GET['id_curso'];

    $query = "SELECT * FROM inscricao WHERE id_inscricao = '$id_inscricao'";
    $resultado = mysqli_query($conn, $query);
    
    if( $resultado && mysqli_num_rows($resultado)>0){
        if($row=mysqli_fetch_assoc($resultado)){
            $estaAtiva = $row['esta_ativa'];
        }
    }

    if($estaAtiva==1){
        $sql = "UPDATE inscricao SET esta_ativa = 0 WHERE id_inscricao = $id_inscricao";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Inscrição desativada')</script>";
            echo "<script>window.location.href = './listar_inscricoes.php?id_curso=$id_curso';</script>"; // Corrigido o formato do URL
        } else {
            echo "Erro ao validar inscrição: " . mysqli_error($conn);
        }

    } else {
        $sql = "UPDATE inscricao SET esta_ativa = 1 WHERE id_inscricao = $id_inscricao";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Inscrição validada')</script>";
            echo "<script>window.location.href = './listar_inscricoes.php?id_curso=$id_curso';</script>"; // Corrigido o formato do URL
        } else {
            echo "Erro ao validar inscrição: " . mysqli_error($conn);
        }
    }

} else {
    echo "ID de inscrição ou ID do curso não fornecidos.";
}
?>
