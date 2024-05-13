<?php
include "../basedados/basedados.h";
session_start();
if (!isset($_SESSION['estaLogado']) || $_SESSION['nivel_acesso'] != 2 && $_SESSION['nivel_acesso'] != 3) {
    header("Location: login.php");
    exit;
}
if(isset($_GET['id_inscricao']) && $_GET['id_curso']) {
    $id_inscricao = $_GET['id_inscricao'];
    $id_curso = $_GET['id_curso'];

    $sql = "DELETE FROM inscricao WHERE id_inscricao = $id_inscricao";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Inscrição eliminada.')</script>";
        echo "<script>window.location.href = './listar_inscricoes.php?id_curso=$id_curso';</script>";
        
    } else {
        echo "<script>alert('Erro ao eliminar inscrição.')</script>";
        echo "<script>window.location.href = './listar_inscricoes.php?id_curso=$id_curso';</script>";
    }

} else {
    echo "ID de inscrição não fornecido.";
}

?>

