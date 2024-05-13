<?php
function exibirNavbar()
{
    
    echo ('
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu-drop" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="home.php"><span>EstFormações</span></a>
            </div>

            <div class="collapse navbar-collapse" id="menu-drop">
                <ul class="nav navbar-nav">
                    <li><a href="home.php">Formações</a></li>
                    <li><a href="contacto.php">Contactos</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">');

    if (!isset($_SESSION['estaLogado'])) {
        echo '<li><a href="login.php">Login</a></li>';
        echo '<li><a href="registrar.php">Registar-se</a></li>';
    } else {
        echo '<li><a>Ola '.$_SESSION['nome'].'</a></li>';
        echo '<li><a href="pagPessoal.php">Minha Área</a></li>';
        echo '<li><a href="logout.php">Logout</a></li>';
    }

    echo ('
                </ul>
            </div>
        </div>
    </nav>');
}
?>