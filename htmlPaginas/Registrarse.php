<?php
require_once "../php/LogicaUsuario.php";
require_once "../php/Login.php";
  //INICIA el arreglo SESSION para mantenerlo
  session_start();
  if (isset($_POST['boton'])) {
    $rol="Usuario";
    $Ci=($_POST['Ci']);
    $Nombre=($_POST['Nombre']);
    $Apellido = ($_POST['Apellido']);
    $Mail=($_POST['Mail']);
    $Direccion=($_POST['Direccion']);
    $Telefono=($_POST['Telefono']);
    $UsserName=($_POST['NombreDeUsuario']);
    $Contrasena=($_POST['Contrasena']);

    $Usuario= new Usuario($Ci,$Nombre,$Apellido, $Mail,$Direccion, $Telefono, $rol);
    $Usuario->AltaUsuario();
    $login= new login($UsserName, $Contrasena);
    $login->AltaLogin($Usuario->getCi());
  }
  ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/Registrarse.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  <title>Inicio a Sesión</title>
</head>

<body>
  <form  class="shadow-lg" action="" method="post">
    <main class="row g-2 align-items-center">
      <div class="col-12">
        <h1>Veterinaria maldonado</h1>
      </div>
      <div class="col-12 mb-2">
      <img src="../archivos.img/LogoVeterinaria.jpeg" alt="/">
      </div>
      <div class="col-md-6">
        <label for="InputNombre" class="form-label">Nombre</label>
        <input name="Nombre" type="text" class="form-control" id="InputNombre">
      </div>
      <div class="col-md-6">
        <label for="InputApellido" class="form-label">Apellido</label>
        <input name="Apellido" type="text" class="form-control" id="InputApellido">
      </div>
      <div class="col-6">
        <label for="InputMail" class="form-label">Mail</label>
        <input name="Mail" type="text" class="form-control" id="InputMail">
      </div>
      <div class="col-6">
        <label for="InputTel" class="form-label">Telefóno</label>
        <input name="Telefono" type="text" class="form-control" id="InputTel">
      </div>
      <div class="col-6">
        <label for="InpuCi" class="form-label">Cedula</label>
        <input name="Ci" type="number" class="form-control" id="InputCi">
      </div>
      <div class="col-6">
        <label for="InputDireccion" class="form-label">Dirección</label>
        <input name="Direccion" type="text" class="form-control" id="InputDireccion">
      </div>
      <div class="col-12">
      <h3>Información de Usuario</h3>
      </div>
      <div class="col-md-6">
        <label for="InputUsuario" class="form-label">Nombre de Usuario</label>
        <input name="NombreDeUsuario" type="text" class="form-control" id="InputUsuario">
      </div>
       <div class="col-6">
        <label for="InputContrasena" class="form-label">Contraseña</label>
        <input name="Contrasena" type="password" class="form-control" id="InputContrasena">
      </div>



        <div class="col-12">
        <button  name="boton" type="submit" class="btn btn-primary">registrarse</button>
      </div>
      <div class="col-12">
                <input class="btn btn-secondary" type="reset" value="Resetear valores">
      </div>
    </main>
  </form>

</div>
</body>


</html>