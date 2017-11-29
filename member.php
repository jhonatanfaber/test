<?php
/**
 * Created by PhpStorm.
 * User: sldia
 * Date: 18/11/2017
 * Time: 12:53
 */

include_once 'lib.php';
//include_once 'tools.php';
View::start('Web de Administradores');

$datosUsuario = User::getLoggedUser();
$idUsuario = $datosUsuario['id'];//para obtener el id del usuario
$nameUsuario = $datosUsuario['email'];

if ($datosUsuario['type'] == 1) {// el usuario es de tipo 1
    $dataAsMemeber = User::getMemberInformation($idUsuario);
    $array = $dataAsMemeber[0];

    View::start('Inicio');
    View::navigation();

    $db = DB::execute_sql('SELECT id,name,date_event,num_participants,description  FROM events_localantena WHERE idantena=?',array($array['antenna']));
    $db->setFetchMode(PDO::FETCH_NAMED);
    $res=$db->fetchAll();
    Event::showEvents($res,'Eventos en tu antena');

    $db = DB::execute_sql('SELECT DISTINCT id, name, date_event, description  FROM participation, events_localantena  
                              WHERE participation.idmember=? AND participation.idevent = events_localantena.id'
                                ,array($idUsuario));
    $db->setFetchMode(PDO::FETCH_NAMED);
    $res1=$db->fetchAll();

    Event::showEvents($res1, 'Eventos propios');
    echo "</article>";
}else{// el usuario no es de tipo 1
    include_once "index.php";
}