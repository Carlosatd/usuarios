<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 03/08/2017
 * Time: 19:42
 */
if(isset($_POST['Deslogar'])){
    session_start();
    session_unset();
    session_destroy();
    header("Location: inicial.php");
    exit();
}else{
    echo 'não deu';
}