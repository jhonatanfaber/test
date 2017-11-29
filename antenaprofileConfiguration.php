<?php
include_once 'lib.php';
View::start('Configurar Perfil');
$datosUsuario = User::getLoggedUser();
if ($datosUsuario['type'] == 2) {// el usuario es de tipo 1
   
    View::navigation();

    $res = DB::execute_sql('SELECT * FROM USERS WHERE id=?',array($datosUsuario['id']));
    $res->setFetchMode(PDO::FETCH_OBJ);
    if($res){
        foreach ($res as $cabecera){
            $name = $cabecera->name;
            $lastName = $cabecera->lastname;
            $password = $cabecera->password;
            $email = $cabecera->email;
            $telephone = $cabecera->phone;
        }
    }

    echo "<form action='updateMember.php' method='post' name='formulario' onsubmit='return validar(\"needed\");'>";
    echo "<h2 style='font-weight:bold;'> Editar Perfil </h2>";
   
    echo "<h4>Nombre:</h4><input class='needed' type='text' name='name' value='$name'>";
    echo "<h4>Apellidos:</h4><input class='needed' type='text' name='surname' value='$lastName'>";
    echo "<h4>Contraseña:</h4><input class='needed' type='password' name='password' value='$password'>";
    echo "<h4>Email:</h4><input class='needed' type='text' name='email' value='$email'>";
    echo "<h4>Telefono:</h4><input type='text' name='mobile' value='$telephone'><br>";
    echo "<input type='submit' name='aceptar' value='Guardar cambios'>";
    echo "</form>";
} else {// el usuario no es de tipo 1
    include_once "index.php";
}
?>


