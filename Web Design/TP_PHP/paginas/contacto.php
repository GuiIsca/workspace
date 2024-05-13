<?php
session_start();
include 'navbar.php';
include '../basedados/basedados.h';
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contato</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap.min.css">
    <style>
        body {
            padding-top: 50px;
            background-color: #f8f9fa;
        }
        .contact-info {
            margin-bottom: 30px;
        }
        .contact-info h2 {
            font-size: 28px;
            margin-bottom: 20px;
        }
        .contact-info h4 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #6c757d;
        }
        .contact-form {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .contact-form h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .contact-form .form-group {
            margin-bottom: 20px;
        }
        .contact-form label {
            font-weight: bold;
            color: #495057;
        }
        .contact-form input[type="text"],
        .contact-form input[type="email"],
        .contact-form textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
        }
        .map-container {
            margin-top: 30px;
        }
        .map-container iframe {
            width: 100%;
            height: 400px;
            border: 0;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
    </style>
</head>

<body>
    <?php exibirNavbar(); ?>

    <div class="container" style="margin-top: 50px;">
        <div class="row">
            <!-- Informações da Empresa -->
            <div class="col-md-6 contact-info">
                <h2>Informações da Empresa</h2>
                <h4>Endereço: Av. do Empresario, Campus da Talagueira, 6000-767 - Castelo Branco</h4>
                <h4>Telefone: 999 999 999</h4>
                <h4>Email: estformacoes@ipcb.com</h4>
            </div>

            <!-- Formulário de Contato -->
            <div class="col-md-6 contact-form">
                <h2 class="text-center">Fale Conosco</h2>
                <form role="form" method="post" action="#">
                    <div class="form-group">
                        <label for="input-nome">Nome</label>
                        <input type="text" class="form-control" id="input-nome" placeholder="Seu nome" name="nome_contacto" required>
                    </div>
                    <div class="form-group">
                        <label for="input-email">Email</label>
                        <input type="email" class="form-control" id="input-email" placeholder="Seu email" name="email_contacto" required>
                    </div>
                    <div class="form-group">
                        <label for="input-mensagem">Mensagem</label>
                        <textarea class="form-control" id="input-mensagem" rows="6" placeholder="Sua mensagem..." name="texto_contacto" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Enviar</button>
                </form>
                <?php 
                    if(isset($_POST['nome_contacto']) && isset($_POST['email_contacto']) && isset($_POST['texto_contacto'])) {
                        $nome_contacto = $_POST['nome_contacto'];
                        $email_contacto = $_POST['email_contacto'];
                        $texto = $_POST['texto_contacto'];

                        $sql = "INSERT INTO mensagem (nome, email, mensagem) VALUES ('$nome_contacto', '$email_contacto', '$texto')";
                        $res = mysqli_query($conn, $sql);

                        if($res) {
                            echo '<div class="text-center"><h5>Mensagem enviada com sucesso!</h5></div>';
                        } else {
                            echo '<div class="text-center"><h5>Não foi possível enviar a mensagem.</h5></div>';
                        }
                    }
                ?>
            </div>
        </div>
        <div class="containe map-container">
                <hr>
                <h1 class="text-center">Localização da Empresa</h1>
                <iframe
                    width="100%"
                    height="400"
                    style="border:0"
                    loading="lazy"
                    allowfullscreen
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3064.441627579968!2d-7.514954223928567!3d39.81951509177132!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd3d5ea6bb2280e1%3A0x1c460157bc4b46c8!2sEscola%20Superior%20de%20Tecnologia%20-%20Instituto%20Polit%C3%A9cnico%20de%20Castelo%20Branco!5e0!3m2!1spt-PT!2spt!4v1714139099724!5m2!1spt-PT!2spt"
                ></iframe>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
</body>
</html>