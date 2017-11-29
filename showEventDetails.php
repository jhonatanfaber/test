<?php
/**
 * Created by PhpStorm.
 * User: Cristian
 * Date: 25/11/2017
 * Time: 1:21
 */
include_once 'lib.php';


$datosUsuario = User::getLoggedUser();
$idUsuario = $datosUsuario['id'];//para obtener el id del usuario
$nameUsuario = $datosUsuario['email'];



if ($datosUsuario['type'] == 1){
    $res=unserialize($_GET['event']);
    View::start($res['name']);
    View::navigation();

    $inst=DB::execute_sql('SELECT * FROM participation WHERE idmember=? AND idevent=?',array($idUsuario,$res['id']));
    $inst->setFetchMode(PDO::FETCH_NAMED);
    $inscrito=$inst->fetchAll();

    foreach ($res as $campo=>$valor){
        if($campo =="name"){
            echo "<div class='event'><h3>$valor</h3>";
        }elseif($campo=="description"){
            echo "<p>$campo:  $valor</p>";
        }elseif($campo=="num_participants") {
            echo "<p>Nº de Plazas:  $valor</p>";
        }elseif($campo == "date_event"){
            echo "<p>Fecha: $valor</p>";
        }elseif ($campo=="id"){
            $id=$valor;
        }
    }
    if(count($inscrito)== 0){
        echo "<a href='applyForEvent.php?idevent=$id'><input type='button' name='seeEvent' 
                          value='Inscribirse'></a></div>";
    }else{
        echo "<h4>Ya esta inscrito</h4></div>";
    }


    View::end();
}else{
    include_once 'index.php';
}
