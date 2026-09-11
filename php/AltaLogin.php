<?php
require_once 'LoginUser.php';
$mail = readline("escriba el mail \n");
$contraseña = readline("escriba la contraseña \n");
$login = new LoginUser($mail, $contraseña);
$login->AltaLoginvalidar($mail, $contraseña);

//PARA LA PRUEBA EL EMAIL ES p@gmail.com