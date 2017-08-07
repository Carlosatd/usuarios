<?php
session_start();
if(isset($_SESSION['email'])){
    $email = $_SESSION['email'];
    unset($_SESSION['email']);
    if($_SESSION['autenticacao']) {
        require '/gerenciador.php';
        $ger = new gerenciador();
        $dados = $ger->buscar($email);
        $nome = $dados['nome'];
        $telefone = $dados['telefone'];
        $endereco = $dados['endereco'];
        $foto = $dados['foto'];
    }else{
        $_SESSION['mode'] = true;
    }
}else{
    header('Location: inicial.php?error=errado');
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
    <style>
        #my{
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }
        #my td, #my th{
            border: 1px solid #ddd;
            padding: 2%;
        }
        #my th{
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            color: white;
        }
        thead{
            background-color: #121212;
        }
        tfoot{
            background-color: #6d7076;
        }

    </style>

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
        <h2>Usuário Logado com sucesso</h2>
            <div>
            <h4>Bem vindo, <?php echo htmlspecialchars($nome)?></h4>
            </div>
        </div>
        <p></p>
        <!--<p><a class="btn btn-primary btn-lg" href="#" role="button">Editar Cadastro &raquo;</a></p>-->
    </div>
    <div class="container">
    <div>
        <div>
            <table class="table table-bordered" id="my">
                <thead class="thead-default">
                <tr>
                    <th>Foto</th>
                    <th>Nome</th>
                    <th>Endereço</th>
                    <th>Telefone</th>
                    <th>Senha</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th><?php if(isset($foto)){ echo "<img src='fotos/".$foto."' alt='Foto de exibição' /><br />";}else{ echo 'noFoto';}?></th>
                    <th><?php  echo $nome;?></th>
                    <th><?php  echo $endereco;?></th>
                    <th><?php  echo $telefone;?></th>
                    <th>Por motivos de segurança nao mostraremos a senha</th>
                </tr>
                </tfoot>
            </table>
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