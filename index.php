<?php
/**
 * Created by PhpStorm.
 * User: sldia
 * Date: 18/11/2017
 * Time: 12:39
 */
include_once 'lib.php';
View::start('Acceso');

if(isset($_GET['logout'])){
    User::logout();
}

echo '<form class="formularioacceso" action="login.php" method="POST" name="datos_usuario" 
xmlns="http://www.w3.org/1999/html"><i class="fa fa-user-circle-o fa-4x" aria-hidden="true">
</i><fieldset><legend>Acceso Centralizado</legend>
<div class="input-group">
  <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user fa-lg" aria-hidden="true"></i></span>
  <input type="text" class="form-control" name="usuario" id="usuario" placeholder="email" aria-describedby="basic-addon1">
</div>

<div class="input-group">
  <span class="input-group-addon" id="basic-addon1"><i class="fa fa-key" aria-hidden="true"></i></span>
  <input type="password" class="form-control" name="contraseña" id="password" placeholder="password" aria-describedby="basic-addon1">
</div>
<div>
<input type="submit" name="enviando" id="enviando" value="Entrar"><label for="enviando">
<i class="fa fa-sign-in fa-2x" aria-hidden="true"></i></input>
</div><a href="register.php">Haz clic aquí para registrarte</a></fieldset></form>';
View::end();