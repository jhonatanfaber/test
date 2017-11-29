<?php
/**
 * Created by PhpStorm.
 * User: sldia
 * Date: 18/11/2017
 * Time: 13:20
 */
include_once 'lib.php';
View::start('Acceso');

echo '<form class="formularioacceso" action="login.php" method="POST" name="datos_usuario" id="datos_usuario"><i class="fa fa-user-circle-o fa-4x" aria-hidden="true"></i><fieldset><legend>Acceso Centralizado</legend>
<div class="input-group">
  <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user fa-lg" aria-hidden="true"></i></span>
  <input type="text" class="form-control" name="usuario" id="usuario" placeholder="email" aria-describedby="basic-addon1">
</div>

<div class="input-group">
  <span class="input-group-addon" id="basic-addon1"><i class="fa fa-key" aria-hidden="true"></i></span>
  <input type="password" class="form-control" name="contraseña" id="password" placeholder="password" aria-describedby="basic-addon1">
</div>

<h4>Usuario o contraseña incorrecta</h4>
<div>
<input type="submit" name="enviando" id="enviando" value="Entrar"><label for="enviando"><i class="fa fa-sign-in fa-2x" aria-hidden="true"></i></label></input>
</div><a href="register.php">Haz clic aquí para registrarte</a></fieldset></form>';

View::end();