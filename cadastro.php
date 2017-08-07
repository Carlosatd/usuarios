<?php
session_start();

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Painel de Controle</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

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
                    <input type="text" name ="email" id="email" placeholder="Email" class="form-control">
                </div>
                <div class="form-group">
                    <input type="password" name="senha" id="senha" placeholder="Password" class="form-control">
                </div>
                <button id= "Logar" name= "Logar" type="submit" class="btn btn-success" formaction="valida.inc.php">Logar</button>
                <button id= "Cadastrar" name= "Cadastrar" type="submit" class="btn btn-warning" formaction="cadastro.php">Cadastrar</button>
            </form>
        </div><!--/.navbar-collapse -->
    </div>
</nav>

<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
    <div class="container">
        <form class="form-horizontal" method="POST" enctype="multipart/form-data">
            <fieldset>

                <!-- Form Name -->
                <legend>Cadastro</legend>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="Nome">Nome Completo</label>
                    <div class="col-md-4">
                        <input id="Nome" name="nome" type="text" placeholder="Digite seu Nome" class="form-control input-md">

                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="endereco">Endereço</label>
                    <div class="col-md-4">
                        <input id="endereco" name="endereco" type="text" placeholder="Digite o Endereço" class="form-control input-md">

                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="Email">Email</label>
                    <div class="col-md-4">
                        <input id="Email" name="email" type="text" placeholder="Digite seu email" class="form-control input-md" required="">

                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="telefone">Telefone</label>
                    <div class="col-md-4">
                        <input id="telefone" name="telefone" type="text" placeholder="(xx)xxxxx-xxxx" class="form-control input-md" required="">

                    </div>
                </div>

                <!-- Password input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="senha">Senha</label>
                    <div class="col-md-4">
                        <input id="senha" name="senha" type="password" placeholder="Digite sua senha" class="form-control input-md" required="">

                    </div>
                </div>

                <!-- File Button -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="foto">Foto</label>
                    <div class="col-md-4">
                        <input id="foto" name="foto" class="input-file" type="file">
                    </div>
                </div>

                <!-- Button (Double) -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="Validar"></label>
                    <div class="col-md-8">
                        <button id="Validar" name="Validar" type="submit" formaction="valida.inc.php" class="btn btn-success">Validar</button>
                        <button id="Cancelar" name="Cancelar" formaction="inicial.php" class="btn btn-danger">Cancelar</button>
                    </div>
                </div>

            </fieldset>
        </form>
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