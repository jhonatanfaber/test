<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 25/11/2017
 * Time: 17:58
 */

include_once 'lib.php';
View::start('Web Antenna');

$datosUsuario = User::getLoggedUser();
$idUsuario = $datosUsuario['id'];//para obtener el id del usuario
$idAntena = Table::valorCampoTabla("SELECT IDANTENA FROM USERANTENA_C_ANTENA WHERE USERANTENA_C_ANTENA.IDUSUARIO = ?", $idUsuario);

$sqlSelect = "SELECT DISTINCT idParticipation, idmember, idevent, date_request, accept FROM EVENTS_LOCALANTENA, PARTICIPATION WHERE EVENTS_LOCALANTENA.IDANTENA = ?";

if ($datosUsuario['type'] == 2) {
    View::navigation();

    if (isset($_GET['showRequest'])) {
        Table::showTableRequest($sqlSelect, 'Solicitudes', $idAntena);
    }
    if (isset($_GET['memberaccept'])) {
        $idPArticipation = $_GET['memberaccept'];
        $sql = "UPDATE PARTICIPATION SET ACCEPT = 1 WHERE IDPARTICIPATION = ?";
        $count = DB::execute_sql($sql, array($idPArticipation));
        if ($count->rowCount() == 1) {
            Table::showTableRequest($sqlSelect, 'Participantes', $idAntena);
        } else {
            echo "<h1>No se pudo aceptar la solicitud</h1>";
        }
    }

    if (isset($_GET['memberReject'])) {
        $idPArticipation = $_GET['memberReject'];
        $sql = "UPDATE PARTICIPATION SET ACCEPT = 2 WHERE IDPARTICIPATION = ?";
        $count = DB::execute_sql($sql, array($idPArticipation));
        if ($count->rowCount() == 1) {
            Table::showTableRequest($sqlSelect, 'Participantes', $idAntena);
        } else {
            echo "<h1>No se pudo denegar la solicitud</h1>";
        }
    }
    View::end();

} else {
    include_once "home_page.php";
}