<?php
include_once 'lib.php';
View::start('Lista de Eventos');
$eventId = $_GET['ID'];
$array=array($eventId);
$datosUsuario = User::getLoggedUser();

if ($datosUsuario['type'] == 2) {// el usuario es de tipo 1

    View::navigation();

    $res = DB::execute_sql('SELECT * FROM events_localantena WHERE id=?',$array);
    $res->setFetchMode(PDO::FETCH_OBJ);
    if($res){
        foreach ($res as $cabecera){
            $id= $cabecera->id;
            $idAntena = $cabecera-> idantena;
            $name= $cabecera->name;

            $date= $cabecera->date_event;
            $dateEvent = new DateTime($date);
            $result = $dateEvent->format('Y-m-d');

            $numParticipants= $cabecera->num_participants;
            $remmainingSeats = $cabecera->remaining_seats;
            $description= $cabecera->description;
        }
    }
    echo "<form action='editEvent2.php' method='post' onsubmit='return validar(\"needed\");'>";
    echo "<input type='hidden' name='id' value='$id'><br>";
    echo "<input type='hidden' name='idAntena' value='$idAntena'><br>";
    echo "<h4>Nombre:</h4><input class='needed' type='text' name='name' value='$name'> <div id='errorMarca'></div>";
    echo "<h4>Fecha:</h4><input class='needed' type='date' name='eventDate' min='$result' value='$result' required>";
    echo "<h4>Nº Participantes:</h4> <input class='needed' type='text' name='nParticipants' value='$numParticipants'><div id='errorPrecio'></div>";
    echo "<h4>Plazas Libres:</h4><input class='needed' type='text' name='rseats' value='$remmainingSeats'><div id='errorPrecio'></div>";
    echo "<h4>Descripción:</h4><textarea rows='4' cols='22' name='description' maxlength='100'>$description</textarea>";
    echo "<br><input type='submit' name='aceptar' value='Guardar'>";
    echo "</form>";

    View::end();

}else{// el usuario no es de tipo 1
    include_once "index.php";
}


