<?php
/**
 * Created by PhpStorm.
 * User: Cristian
 * Date: 27/11/2017
 * Time: 17:24
 */
include_once 'lib.php';

$datosUsuario = User::getLoggedUser();
if ($datosUsuario['type'] == 1 || $datosUsuario['type'] == 2) {
    User::logout();
    header('Location:home_page.php');
}