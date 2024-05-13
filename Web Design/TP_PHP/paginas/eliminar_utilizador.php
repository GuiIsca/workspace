<?php
ob_start();
session_start();
include "../basedados/basedados.h";

if (!isset($_SESSION['estaLogado']) || $_SESSION['nivel_acesso'] != 3) {
    header("Location: login.php");
    exit; 
}
if (!isset($_GET['id_utilizador'])) {
    echo "Parâmetro id_utilizador não foi fornecido.";
    exit; 
}

$id_utilizador = $_GET['id_utilizador'];


$sql = "DELETE from utilizador WHERE id_utilizador='$id_utilizador'";


$resultado = mysqli_query($conn,$sql);

if($resultado && mysqli_affected_rows($conn)>0){
    echo "<script>alert('Utilizador deletado')</script>";
    echo "<script>window.location.href = './gerir_utilizadores.php';</script>";
} else {
    echo "erro ao deletar utilizador";
}

?>
