<?php

include_once 'lib.php';

$datosUsuario = User::getLoggedUser();

if ($datosUsuario['type'] == 1 || $datosUsuario['type'] == 2) {
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $email = $_POST["email"];
    $mobile = $_POST["mobile"];
    $password = $_POST["password"];
    $passw = Table::valorCampoTabla('SELECT PASSWORD FROM USERS WHERE ID = ?', $datosUsuario['id']);

    if ($password === $passw) {
        DB::execute_sql('UPDATE users SET name=?,lastname=?,email=?,phone=? WHERE id=?',
            array($name, $surname, $email, $mobile, $datosUsuario["id"]));
    } else {
        $pass = md5($password);
        DB::execute_sql('UPDATE users SET password=?,name=?,lastname=?,email=?,phone=? WHERE id=?',
            array($pass, $name, $surname, $email, $mobile, $datosUsuario["id"]));
    }

    if ($datosUsuario["type"] == 1) {
        $antenna = $_POST["antenna"];
        $idAntena = Table::valorCampoTabla('SELECT IDANTENA FROM userantena_c_antena WHERE nameantena = ?', $antenna);
        DB::execute_sql('UPDATE members SET antenna = ? WHERE idusuario = ?', array($idAntena, $datosUsuario["id"]));
        header("location:member.php");
    } else {
        header("location:antena.php");
    }
} else {
    include_once "index.php";
}
