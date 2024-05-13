<?php

$host = "localhost";
$user = "root";
$password = "";
$base_dados = "lpi_tp";

$conn = mysqli_connect($host,$user,$password) 
 or die ("Não foi possível estabelecer conexão! " . mysqli_connect_error($conn));


$conn_bd = mysqli_select_db($conn,$base_dados);
if(!$conn_bd){
    echo "Não foi possivél conectar a base de dados";
} 

?>