<?php
include_once 'lib.php';
View::start('Modificar Bebidas');
View::navigation();

$id = $_POST['id'];
$name = $_POST['name'];
$date = $_POST['eventDate'];
$numParticipants = $_POST['nParticipants'];
$remainingSeats = $_POST['rseats'];
$description = $_POST['description'];
$array = array($name, $date, $numParticipants, $remainingSeats, $description, $id);
DB::execute_sql('UPDATE events_localantena SET name=?, date_event=?, num_participants=?,
                                                            remaining_seats=?,description=? where id=?;', $array);
header("location:listEvents.php");

View::end();


