<?php
/**
 * Created by PhpStorm.
 * User: Cristian
 * Date: 24/11/2017
 * Time: 9:17
 */
include_once ('lib.php');


$datosUsuario = User::getLoggedUser();
$idUsuario = $datosUsuario['id'];
$nameUsuario = $datosUsuario['email'];

if ($datosUsuario['type'] == 1) {// el usuario es de tipo member

    View::start('Bandeja de Entrada');
    View::navigation();

    $sqlSelect = "SELECT idevent, date_request, accept FROM PARTICIPATION WHERE PARTICIPATION.IDMEMBER = ?";
    Table::showInbox($sqlSelect, "Solicitudes", $idUsuario);
    View::end();

}else{// el usuario no es de tipo 1
    include_once "index.php";
}