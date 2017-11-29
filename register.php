<?php
/**
 * Created by PhpStorm.
 * User: sldia
 * Date: 18/11/2017
 * Time: 12:41
 */
include_once("lib.php");
View::start('añadir');
View::navigation();

$db=DB::execute_sql('SELECT * FROM users WHERE type=?;',array(2));
$db->setFetchMode(PDO::FETCH_NAMED);
$res=$db->fetchAll();

echo "<form class='formInscrip' action='createUser.php' name = 'user_form' method='post' onsubmit = \"return validacion(1)\"><fieldset><legend>Datos de usuario</legend>
    
    <h4>Tipo:</h4><input type='radio' name='type' id = 'type' value=2 checked = true onclick='showForm(\"antenna\")'><label>Antena</label>
    <input type='radio' name='type' id = 'type' value=1 onclick='showForm(\"member\")'><label>Miembro</label><div class = 'type' id = 'error_type'></div>
    <h4>Nombre:</h4><input type='text' name='nombre' id = 'nombre' required><div class = 'error' id = 'error_name'></div>
    <h4>Apellidos:</h4><input type='text' name='surname' id = 'surname' required><div class = 'error' id = 'error_surname'></div>
    <h4>Contraseña:</h4><input type='password' name='clave' id = 'clave' required> <div class = 'error' id = 'error_passwd'></div>
    <h4>Email:</h4><input type='email' name='email' id = 'email' required><div class = 'error' id = 'error_email'></div>
    <h4>Ciudad:</h4><input type='text' name='city' id = 'city' required><div class = 'error' id = 'error_city'></div>
    <h4>Teléfono:</h4><input type='tel' name='phone' id = 'phone' pattern=\"([0-9]{6,15})\"><div class = 'error' id = 'error_phone'></div>";

    echo "<div id='member'><h4>Elija Antena:</h4>";
    echo "<select name='antenna'>";
    foreach($res as $filas){
        foreach($filas as $campo=>$valor){
            if($campo=="name"){
                echo "<option value='$valor'>$valor</option>";
            }
        }
    }
    echo "</select></div>";
    echo "<h4>Descripción Personal:</h4>
    <textarea name='comment' rows='5' cols='40'></textarea><div class = 'error' id = 'error_description'></div>
    
    <h4>Foto:</h4><input type='file' name='file' id = 'file'><div class = 'error' id = 'error_file'></div><br>
    <div class = 'error' id = 'error_type'></div>  
    <button type='submit'>Registrarse</button>
    </fieldset>
    </form>";
