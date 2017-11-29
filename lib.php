<?php
/**
 * Created by PhpStorm.
 * User: sldia
 * Date: 18/11/2017
 * Time: 12:24
 */

class View{
    public static function  start($title){
        $html = "<!DOCTYPE html>
        <html>
        <head>
        <meta charset=\"utf-8\">
        <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css\">
        <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\">
        <link rel=\"stylesheet\" type=\"text/css\" href=\"css\styles.css\">
        <script src=\"js\scripts.js\"></script>
        <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js\"></script>
        <title>$title</title>
        </head>
        <body>";
        User::session_start();
        echo $html;
    }
    public static function navigation(){
        $userData = User::getLoggedUser();
        $userType = $userData['type'];
        $userName = $userData['name'];

        echo "<nav><ul>
            <li ><h4>$userName</h4></li>";
        if($userType == '1'){
            echo '
                <li><a href="member.php">Inicio</a></li>
                <li><a href="findEvents.php">Buscar Eventos</a></li>
                <li><a href="inbox.php">Mensajes</a></li>';
                self::logout();
                echo "<li style='float: right;'><a href='memberProfileConfiguration.php' title='Editar perfil'><i class='fa fa-user-circle' aria-hidden=\"true\" 
                style='font-size: 30px;'></i></a>
                </li>";
        }elseif($userType == '2'){
            echo '
            <li><a href="antena.php">Inicio</a></li>
            <li><a href="listEvents.php">Lista de eventos</a></li>
            <li><a href="createEvent.php">Crear evento</a></li>
            <li><a href="participation.php?showRequest">Ver solicitudes</a></li>';
            self::logout();
            echo "<li style='float: right;'><a href='antenaprofileConfiguration.php' title='Editar perfil'>
                   <i class='fa fa-user-circle' aria-hidden=\"true\" 
                    style='font-size: 30px;'></i></a>
             </li>";
        }
        echo "</ul></nav>";
    }
    public static function end(){
        echo '</body>
        </html>';
    }
    private static function logout(){
        echo "<li style='float: right;'><a href='logout.php' title='Logout'><i class='fa fa-sign-out' aria-hidden=\"true\" 
        style='font-size: 30px;'></i></a>
        </li>";
    }
}

class DB{
    private static $connection = null;

    public static function get(){
        if(self::$connection === null){
            self::$connection = new PDO('mysql:host=localhost;dbname=gs1','root', '');
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$connection;
    }

    public static function execute_sql($sql,$parms=null){
        try {
            $db = self::get();
            $ints= $db->prepare ( $sql );
            if ($ints->execute($parms)) {
                return $ints;
            }
        }
        catch (PDOException $e) {
            //echo '<h3>Error en al DB: ' . $e->getMessage() . '</h3>';
        }
        return false;
    }
}

class User{
    public static function session_start(){
        if(session_status () === PHP_SESSION_NONE){
            session_start();
        }
    }
    public static function getLoggedUser(){ //Devuelve un array con los datos de la cuenta o false
        self::session_start();
        if(!isset($_SESSION['user'])) return false;
        return $_SESSION['user'];
    }
    public static function login($user, $password){ //Devuelve verdadero o falso según
        self::session_start();
        $db=DB::get();
        $inst=$db->prepare('SELECT * FROM users WHERE email=? and password=?');
        $inst->execute(array($user,md5($password)));
        $inst->setFetchMode(PDO::FETCH_NAMED);
        $res=$inst->fetchAll();
        if(count($res)== 1){
            $_SESSION['user']=$res[0]; //Almacena datos del usuario en la sesión
            return true;
        }
        //echo 'false';
    }
    public static function logout(){
        self::session_start();
        unset($_SESSION['user']);
    }

    public static function getMemberInformation($idUsuario){
        self::session_start();
        $db=DB::get();
        $inst=$db->prepare('SELECT * FROM members WHERE idusuario=?');
        $inst->execute(array($idUsuario));
        $inst->setFetchMode(PDO::FETCH_NAMED);
        $res=$inst->fetchAll();

        return $res;
    }

    public static function findUser($usuario){ //Devuelve verdadero o falso según
        self::session_start();
        $db=DB::get();
        $inst=$db->prepare('SELECT * FROM users WHERE name=?');
        $inst->execute(array($usuario));
        $inst->setFetchMode(PDO::FETCH_NAMED);
        $res=$inst->fetchAll();
        if(count($res)==1){
            return true;
        }
        return false;
    }

}

class Event{
    public static function showEvents($res, $tableName){
        $bool=true;
        echo "<table class='tablas'><caption>$tableName</caption>";
        foreach ($res as $filas){
            echo "<tr>";
            if($bool){
                foreach ($filas as $campo=>$valor){
                    if($campo != "id"){
                        if($campo=="date_event"){
                            echo "<th>Fecha del Evento</th>";
                        }elseif ($campo=="name"){
                            echo "<th>Eventos</th>";
                        }elseif ($campo=="num_participants"){
                            echo "<th>Nº de Plazas</th>";
                        }else{
                            echo "<th>$campo</th>";
                        }
                    }
                }
                $bool=false;
                echo "<th>Opciones</th></tr>";
            }

            foreach ($filas as $campo=>$valor){
                if($campo=="description"){
                    $datos=urlencode(serialize($filas));
                    echo "<td>$valor</td>
                          <td><a href='showEventDetails.php?event=$datos'><input type='button' name='seeEvent' 
                          value='Ver Evento'></a></td>";

                }elseif($campo != "id"){
                    echo "<td>$valor</td>";
                }
            }
            echo "</tr>";
        }
        echo "</table>";
    }

}

class Table{
    public static function showTableRequest($sql, $nombreTabla, $idUsuario=null){

        if(func_num_args()==2){// para saber el numero de argumentos pasado,xk dependiendo de una consulta u otra necesito 2 o 3 argumentos
            $res = DB::execute_sql($sql);
        }else{
            $res = DB::execute_sql($sql,array($idUsuario));
        }

        if($res){
            $res->setFetchMode(PDO::FETCH_NAMED);
            $first=true;
            echo "<table class='tablas'><caption>$nombreTabla</caption><tr>";
            foreach($res as $game){
                if($first){
                    foreach($game as $field=>$value){
                        self::fieldSwitchRequest($field);
                    }
                    echo "<th>Operación</th>";
                    $first = false;
                    echo "</tr>";
                }
                echo "<tr>";
                foreach($game as $field=>$value){
                    if($field == "date_request"){
                        $date = new DateTime($value);
                        $result = $date->format('d-m-Y H:i');
                        echo "<td>$result</td>";
                    }elseif ($field == "idmember"){
                        $nameMember = self::valorCampoTabla("SELECT NAME FROM USERS WHERE USERS.ID = ?", $value);
                        echo "<td>$nameMember</td>";
                    }elseif ($field == 'idevent'){
                        $nameEvent = self::valorCampoTabla('SELECT NAME FROM EVENTS_LOCALANTENA WHERE EVENTS_LOCALANTENA.ID = ?', $value);
                        echo "<td>$nameEvent</td>";
                    }elseif ($field == 'accept'){
                        if($value == 0){
                            echo "<td>Pendiente</td>";
                        }elseif ($value == 1){
                            echo "<td>Aceptado</td>";
                        }else{
                            echo "<td>Rechazado</td>";
                        }
                    }elseif ($field == 'idParticipation'){
                        $idParticipation = $value;
                    }
                    else{
                        echo "<td>$value</td>";
                    }
                }
                echo "<td><a href='participation.php?memberaccept=$idParticipation'><input type='button' value='Aceptar'></a>";
                echo "<a href='participation.php?memberReject=$idParticipation'><input type='button' value='Rechazar'></a></td>";
                echo "</tr>";
            }
            echo '</table>';
        }
    }


    public static function showInbox($sql, $nombreTabla, $idUsuario=null){

        if(func_num_args()==2){// para saber el numero de argumentos pasado,xk dependiendo de una consulta u otra necesito 2 o 3 argumentos
            $res = DB::execute_sql($sql);
        }else{
            $res = DB::execute_sql($sql,array($idUsuario));
        }

        if($res){
            $res->setFetchMode(PDO::FETCH_NAMED);
            $first=true;
            echo "<table class='tablas'><caption>$nombreTabla</caption><tr>";
            foreach($res as $game){
                if($first){
                    foreach($game as $field=>$value){
                        self::fieldSwitchRequest($field);
                    }
                    $first = false;
                    echo "</tr>";
                }
                echo "<tr>";
                foreach($game as $field=>$value){
                    if($field == "date_request"){
                        $date = new DateTime($value);
                        $result = $date->format('d-m-Y H:i');
                        echo "<td>$result</td>";
                    }elseif ($field == "idmember"){
                        $nameMember = self::valorCampoTabla("SELECT NAME FROM USERS WHERE USERS.ID = ?", $value);
                        echo "<td>$nameMember</td>";
                    }elseif ($field == 'idevent'){
                        $nameEvent = self::valorCampoTabla('SELECT NAME FROM EVENTS_LOCALANTENA WHERE EVENTS_LOCALANTENA.ID = ?', $value);
                        echo "<td>$nameEvent</td>";
                    }elseif ($field == 'accept'){
                        if($value == 0){
                            echo "<td>Pendiente</td>";
                        }elseif ($value == 1){
                            echo "<td>Aceptado</td>";
                        }else{
                            echo "<td>Rechazado</td>";
                        }
                    }
                    else{
                        echo "<td>$value</td>";
                    }
                }
                echo "</tr>";
            }
            echo '</table>';
        }
    }

    public static function valorCampoTabla($sql,$param=null){
        if (func_num_args() == 1) {//para llamarlo cuando quiero el precio del pedido
            $consulta = DB::execute_sql($sql);
            return $consulta->fetchcolumn();// para obtener el valor de la consulta
        }
        $consulta = DB::execute_sql($sql,array($param));
        return $consulta->fetchcolumn();// para obtener el valor de la consulta
    }

    private static function fieldSwitchRequest($field){
        switch ($field) {
            case 'idmember':
                echo "<th>Nombre de usuario</th>";
                break;
            case 'idevent':
                echo "<th>Nombre del evento</th>";
                break;
            case 'date_request':
                echo "<th>Fecha</th>";
                break;
            case 'accept':
                echo "<th>Estado</th>";
                break;
        }
    }
}
