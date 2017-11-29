<?php
/**
 * Created by PhpStorm.
 * User: Cristian
 * Date: 24/11/2017
 * Time: 9:16
 */
include_once ('lib.php');

$datosUsuario = User::getLoggedUser();
$idUsuario = $datosUsuario['id'];//para obtener el id del usuario
$nameUsuario = $datosUsuario['email'];

if ($datosUsuario['type'] == 1) {// el usuario es de tipo 1
    $db = DB::execute_sql('SELECT id,name,date_event ,num_participants,description  FROM events_localantena');
    $db->setFetchMode(PDO::FETCH_NAMED);
    $res=$db->fetchAll();

    View::start('Busqueda de eventos');
    View::navigation();
    Event::showEvents($res, 'Lista de Eventos');

    echo "</article>";
}else{// el usuario no es de tipo 1
    include_once "index.php";
}