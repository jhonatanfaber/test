<?php
include_once 'lib.php';
View::start('Lista de Eventos');
$datosUsuario = User::getLoggedUser();
if ($datosUsuario['type'] == 2) {// el usuario es de tipo 1

    View::navigation();

    $res = DB::execute_sql('SELECT * FROM events_localantena');
    $res->setFetchMode(PDO::FETCH_NAMED);

        $flag=true;
        echo "<table class='tablas'><caption>Eventos</caption>";
        foreach($res as $cabecera){

            if($flag){
                echo "<tr>";
                foreach($cabecera as $field=>$value){
                    if ($field != 'id'){
                        echo "<th> $field  </th>";
                    }
                }
                echo "<th> Operación </th>";
                echo "</tr>";
                $flag=false;
            }
            echo "<tr>";
            foreach($cabecera as $field=>$value){
                if($field == 'id'){
                    $id = $value;
                }elseif ($field == 'date_event'){
                    $date = new DateTime($value);
                    $result = $date->format('d-m-Y H:i');
                    echo "<td>$result</td>";
                }
                else{
                    echo "<td> $value  </td>";
                }
            }
            echo "<td><a href=editEvent.php?ID=$id><input type='button' name='modificar' value='Modificar'></a></td>";
            echo "</tr>";
        }
        echo "</table>";
    View::end();

}else{// el usuario no es de tipo 1
    include_once "index.php";
}
?>


