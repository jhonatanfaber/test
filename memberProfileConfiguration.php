<?php
include_once 'lib.php';
View::start('Configurar Perfil');
$datosUsuario = User::getLoggedUser();
$db=DB::execute_sql('SELECT * FROM users WHERE type = ?',array(2));
$db->setFetchMode(PDO::FETCH_NAMED);
$res=$db->fetchAll();
if ($datosUsuario['type'] == 1) {// el usuario es de tipo 1

    View::navigation();

    $result = DB::execute_sql('SELECT * FROM USERS WHERE id = ?',array($datosUsuario['id']));
    $result->setFetchMode(PDO::FETCH_OBJ);
    if($result){
        foreach ($result as $cabecera){
            $name = $cabecera->name;
            $lastName = $cabecera->lastname;
            $password = $cabecera->password;
            $email = $cabecera->email;
            $telephone = $cabecera->phone;
        }
    }

   $antenaName=Table::valorCampoTabla('SELECT userantena_c_antena.nameantena FROM members,userantena_c_antena
WHERE userantena_c_antena.idantena=members.antenna AND members.idusuario = ?', $datosUsuario['id']);

    echo "<form action='updateMember.php' method='post' name='formulario' onsubmit='return validar(\"needed\")'>";
    echo "<h2 style='font-weight: bold;'> Editar Perfil </h2>";
    echo "<h4>Nombre:</h4><input class='needed' type='text' name='name' value='$name'>";
    echo "<h4>Apellidos:</h4><input class='needed' type='text' name='surname' value='$lastName'>";
    echo "<h4>Contraseña:</h4><input class='needed' type='password' name='password' value='$password'>";
    echo "<h4>Email:</h4><input class='needed' type='text' name='email' value='$email'>";
    echo "<h4>Telefono:</h4><input type='text' name='mobile' value='$telephone'>";
    echo "<h4>Elija Antena:</h4>";
    echo "<select name='antenna'>";

    foreach($res as $filas){
        foreach($filas as $campo=>$valor){
            if($campo=="name"){
                if($valor==$antenaName){
                    echo "<option value='$valor'>$valor</option>";
                }else{
                    echo "<option value='$valor'>$valor</option>";
                }
            }
        }
    }
    echo "</select><br><br><br>";
    echo "<input type='submit' name='aceptar' value='Guardar'>";
    echo "</form>";
} else {// el usuario no es de tipo 1
    include_once "index.php";
}


