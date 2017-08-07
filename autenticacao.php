<?php
session_start();
if(isset($_SESSION['email'])){
    if($_SESSION['autenticacao']) {
        header('Location: logado.php');
    }
    $email=$_SESSION['email'];

}else if(isset($_GET['email'])&&!empty($_GET['email']) AND isset($_GET['hash'])&&!empty($_GET['hash'])){

    require_once '/gerenciador.php';
    $ger = new gerenciador();
    //mudar a forma do valida hash, talvez o busca * e depois pega $dado['hash]
    $resp =$ger->validaHash($_GET['email'],$_GET['hash']);
    if($resp == 1){
        $_SESSION['email']=$_GET['email'];
        $_SESSION['autenticacao'] = true;
        header('Location: logado.php');
    }else{
        header('Location: inicial.php?error=old');
    }

}else{
    session_unset();
    session_destroy();
    header('Location: inicial.php?error=WRONG');
}


?>
<!--Usando Boostrap -->
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <link href="../css/bootstrap.min.css" rel="stylesheet">


    <title>Painel de Controle</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/estilo.css" >

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="jumbotron.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<?php

?>



<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="inicial.php">Sistema de Login</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <form class="navbar-form navbar-right" method="POST">
                <div class="form-group">
                    <p style="color:aliceblue"><?php echo htmlspecialchars($email); ?> </p>
                </div>
                <button id= "Deslogar" name= "Deslogar" type="submit" class="btn btn-danger" formaction="logout.php">Sair</button>
            </form>
        </div><!--/.navbar-collapse -->
    </div>
</nav>

<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
    <div class="container">
        <div>
            <h2>Autenticação necessária</h2>
            <h4>Um email de autenticação foi enviado para, <?php echo htmlspecialchars($email)?> . Basta seguir as instruções para começar a usar</h4>
        </div>
        <p></p>
    </div>
    <div class="container">
        <div>
            <div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
<script src="../../dist/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>