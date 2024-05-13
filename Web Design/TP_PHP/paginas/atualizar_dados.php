<?php
include "../basedados/basedados.h";
session_start();

// Verifica se os dados do formulário foram enviados
if (isset($_POST['user_email']) && isset ($_POST['user_nome'])) {
    // Recebe os dados do formulário
    $nome = $_POST['user_nome'];
    $email = $_POST['user_email'];

    $sql = "UPDATE utilizador SET nome='$nome', email='$email' WHERE id_utilizador=" . $_SESSION['id_utilizador'];
    mysqli_query($conn, $sql);

    // Atualiza os dados da sessão
    $_SESSION['nome'] = $nome;
    $_SESSION['email'] = $email;

    // Redireciona de volta para a página de dados pessoais
    echo "<script>alert('Alteração realizada com sucesso')</script>";
    echo "<script>window.location.href = './gerir_utilizadores.php';</script>";
    exit();
} else {
    // Se o formulário não foi submetido via POST, redireciona para a página de dados pessoais
    header("Location: dados_pessoais.php");
    exit();
}
?>
