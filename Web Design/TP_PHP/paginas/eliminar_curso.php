<?php
ob_start();
include "../basedados/basedados.h";
include 'navbar.php';
session_start();
if (!isset($_SESSION['estaLogado']) || $_SESSION['nivel_acesso'] != 3) {
    header("Location: login.php");
    exit;
}
if(!isset($_GET['id_curso'])){
    echo "<script>alert('Não foi pssível recuprar o curso')</script>";
    echo "<script>window.location.href = './gerir_curso.php';</script>";
}
$id_curso = $_GET['id_curso'];

$sql="DELETE FROM curso WHERE id_curso='$id_curso'";

$resultado=mysqli_query($conn,$sql);

if($resultado && mysqli_affected_rows($conn)){
    echo "<script>alert('O curso foi removido.')</script>";
    echo "<script>window.location.href = './gerir_curso.php';</script>";
} else {
    echo "<script>alert('Não foi possível remover o curso.')</script>";
    echo "<script>window.location.href = './gerir_curso.php';</script>";
}

?>