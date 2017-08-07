<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 03/08/2017
 * Time: 01:57
 */
session_start();
require_once '/gerenciador.php';

if(isset($_POST['Logar'])){

    $ger = new gerenciador();
    if (!empty($_POST['email']) && !empty($_POST['senha'])) {
       if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
           $temp = $ger->logar($_POST['email'], $_POST['senha']);
           if ($temp==1) {
               $_SESSION['email'] = $_POST['email'];
               $resp = $ger->confirmaValidEmail($_SESSION['email']);
               if(!$resp){
                   $_SESSION['autenticacao'] = false;
               }else{
                   $_SESSION['autenticacao'] = true;
               }
               header('Location: autenticacao.php');
           } elseif($temp==0) {
               echo "Error";
               header('Location: inicial.php?error=autError');
               exit();
           }else{
               header('Location: inicial.php?error=error');
               exit();
           }
       }else{
           //$_SESSION['error']='mail';
           header('Location: inicial.php?error=email');
           exit();
       }
    }else{
        header('Location: inicial.php?error=empty');
        exit();
    }

exit();
}elseif(isset($_POST['Validar'])) {
    //require '/gerenciador.php';
    $ger = new gerenciador();
    //$conect = new conexao();
    $hash = md5(uniqid(time()));
    $ger->cadastrar($_POST['nome'],$_POST['email'],$_POST['telefone'],$_POST['endereco'],$_POST['senha'],$hash);
    if($ger == false){
        header("Location: inicial.php?error=uso");
        exit();
    }else{
        //inserir foto
        if(!empty($_FILES['foto'])){
            $array_fotos = $_FILES['foto'];
            $ger->atualizaFoto($_POST['email'],$array_fotos);
        }
        $ger->validaEmail($_POST['email'],$_POST['nome'],$hash);
        $_SESSION['email'] = $_POST['email'];
        header("Location: autenticacao.php");
    }


}else{
    session_unset();
    session_destroy();
    header("Location: inicial.php?error=valida");
    exit();

}