<?php
/**
 * Created by PhpStorm.
 * User: sldia
 * Date: 18/11/2017
 * Time: 13:33
 */

include_once 'lib.php';
//include_once 'tools.php';
View::start('Web de Administradores');

$datosUsuario = User::getLoggedUser();
$idUsuario = $datosUsuario['id'];//para obtener el id del usuario
$nameUsuario = $datosUsuario['email'];

if ($datosUsuario['type'] == 2) {// el usuario es de tipo 2

    View::navigation();

    View::end();

}else{// el usuario no es de tipo 1
    include_once "index.php";
}