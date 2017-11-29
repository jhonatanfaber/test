<?php
include_once 'lib.php';
View::start('Lista de Eventos');
$datosUsuario = User::getLoggedUser();
$id = $datosUsuario['id'];
$idAntena = Table::valorCampoTabla('SELECT IDANTENA FROM USERANTENA_C_ANTENA WHERE IDUSUARIO = ?',$id);
$city = Table::valorCampoTabla('SELECT CITY FROM users WHERE id = ?', $id);
$date = date("Y-m-d");

if ($datosUsuario['type'] == 2) {// el usuario es de tipo 1

    if (isset($_POST['aceptar'])){
        $name = $_POST['eventName'];
        $dateEvent = $_POST['eventDate'];
        $numParticipants = $_POST['numberParticipants'];
        $description = $_POST['description'];

        $count = DB::execute_sql("INSERT INTO events_localantena(idantena, name, date_event, city, num_participants, remaining_seats, description) 
                                      VALUES('$idAntena','$name', '$dateEvent', '$city', '$numParticipants', '$numParticipants', '$description')");
        if($count->rowCount() != 1){
            echo "<h3>No se ha podido crear el evento.</h2>";
        }
    }

    View::navigation();

    echo "<form action='createEvent.php' method='post' name='formulario' onsubmit='return validar(\"needed\");'>";
    echo "<h4>Nombre:</h4> <input class='needed' type='text' name='eventName' >";
    echo "<h4>Fecha:</h4><input class='needed' type='date' name='eventDate' min='$date' value='$date' required>";
    echo "<h4>Nº Participantes:</h4><input class='needed' type='text' name='numberParticipants' >";
    echo "<h4>Descripción:</h4><textarea rows='4' cols='22' name='description' maxlength='100'></textarea>";
    echo "<br><input type='submit' name='aceptar' value='Crear'>";
    echo "</form>";


    echo "<div class='out'>";
    echo "<form method='post' action='' enctype='multipart/form-data'>";
    echo "<input type='file' name='attachedfile'>";
    echo " </form>";
    echo "</div>";

} else {// el usuario no es de tipo 1
    include_once "index.php";
}
