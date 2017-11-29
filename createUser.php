<?php
include_once 'lib.php';

$name = $_POST["nombre"];
$surname = $_POST["surname"];
$password = $_POST["clave"];
$email = $_POST["email"];
$city = $_POST['city'];
$mobile = $_POST["phone"];
$type = $_POST["type"];

if (!User::findUser($name)) {

    $line = DB::execute_sql(' INSERT INTO users(type,password,name,lastname,email,city, phone) VALUES(?,?,?,?,?,?,?) ',
                        array($type, md5($password), $name, $surname, $email, $city, $mobile));
    if($line->rowCount() != 1){
        echo "<h3>El usuario no se pudo registrar.</h3>";
    }

    $idUser = Table::valorCampoTabla("SELECT id FROM users WHERE email=?", $email);

    if ($type == 1) {
        $antenna = $_POST["antenna"];
        $idAntena = Table::valorCampoTabla('SELECT IDANTENA FROM userantena_c_antena WHERE nameantena = ?', $antenna);
        echo "ID antena: $idAntena";
        $count = DB::execute_sql("UPDATE members SET antenna=?,mobile=? where idusuario=?", array($idAntena, $mobile, $idUser));
        if($count->rowCount() != 1){
            echo "<h3>El usuario no se pudo registrar.</h3>";
        }else{
            header("location:index.php");
        }
    }else{
        $count = DB::execute_sql("UPDATE userantena_c_antena SET nameantena=?,addressantena=? where idusuario=?", array($name, $email, $idUser));
        if($count->rowCount() != 1){
            echo "<h3>El usuario no se pudo registrar.</h3>";
        }else{
            header("location:index.php");
        }
    }
    header("location:index.php");
} else {
    echo "<h1>Este usuario ya existe</h1>";
    header("location:register.php");
}
