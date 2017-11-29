<?php
/**
 * Created by PhpStorm.
 * User: sldia
 * Date: 18/11/2017
 * Time: 12:41
 */

include_once("lib.php");

if(isset($_POST['enviando'])){
    $usuario = $_POST['usuario'];
    $password = $_POST['contraseña'];

    User::login($usuario,$password);
    $datosUsuario = User::getLoggedUser();

    if ($datosUsuario['type'] == 1){//Usuario miembro
        include_once "member.php";
    }
    elseif($datosUsuario['type'] == 2){//Usuario antena
        include_once "antena.php";
    }
    else{//usuario no registrado
        include_once "nouser.php";
    }
}