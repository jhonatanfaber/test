<?php
include_once 'lib.php';
$datosUsuario = User::getLoggedUser();
$id=$datosUsuario['id'];

if ($datosUsuario['type'] == 1) {
    $idevent = $_GET['idevent'];

    DB::execute_sql("INSERT INTO participation(idmember,idevent,accept)
    VALUES($id,$idevent,0)");

    header("Location:member.php");
} else {
    include_once "home_page.php";
}