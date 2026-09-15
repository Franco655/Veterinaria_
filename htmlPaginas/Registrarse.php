<?php
require_once "../php/LogicaUsuario.php";
require_once "../php/Login.php";
  //INICIA el arreglo SESSION para mantenerlo
  session_start();
  $Error=true;
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
    $Error=$Usuario->AltaUsuario();
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
        <input name="Nombre" type="text" class="form-control" id="InputNombre" required>
      </div>
      <div class="col-md-6">
        <label for="InputApellido" class="form-label">Apellido</label>
        <input name="Apellido" type="text" class="form-control" id="InputApellido" required>
      </div>
      <div class="col-6">
        <label for="InputMail" class="form-label">Mail</label>
        <input name="Mail" type="email" class="form-control" id="InputMail" required>
      </div>
      <div class="col-6">
        <label for="InputTel" class="form-label">Telefóno</label>
        <input name="Telefono" type="tel" class="form-control" id="InputTel" required>
      </div>
      <div class="col-6">
        <label for="InpuCi" class="form-label">Cedula</label>
        <input name="Ci" type="number" class="form-control" id="InputCi" required>
      </div>
      <div class="col-6">
        <label for="InputDireccion" class="form-label">Dirección</label>
        <input name="Direccion" type="text" class="form-control" id="InputDireccion" required>
      </div>
      <div class="col-12">
      <h3>Información de Usuario</h3>
      </div>
      <div class="col-md-6">
        <label for="InputUsuario" class="form-label">Nombre de Usuario</label>
        <input name="NombreDeUsuario" type="text" class="form-control" id="InputUsuario" required>
      </div>
       <div class="col-6">
        <label for="InputContrasena" class="form-label">Contraseña</label>
        <input name="Contrasena" type="password" class="form-control" id="InputContrasena" required>
      </div>



        <div class="col-12">


        <button  name="boton" type="submit" class="btn btn-primary" id="liveToastBtn">registrarse</button>
      </div>
      <div class="col-12">
                <input class="btn btn-secondary" type="reset" value="Resetear valores">
      </div>
<div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center w-100 position-fixed top-0 start-0 p-3" style="z-index: 11; pointer-events: none;">

  <!-- Tu Toast original (le agregamos pointer-events para que se pueda hacer clic en el botón de cerrar) -->
  <!-- Contenedor invisible posicionado abajo a la derecha -->
<div aria-live="polite" aria-atomic="true" class="d-flex justify-content-end align-items-end w-100 h-100 position-fixed bottom-0 end-0 p-3" style="z-index: 11; pointer-events: none;">

  <!-- Tu Toast original (con eventos de clic reactivados para poder cerrarlo) -->
  <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" style="pointer-events: auto;">
    <div class="toast-header">
      <img src="../archivos.img/LogoVeterinaria.jpeg" class="rounded me-2" alt="..." style="width: 20px; height: 20px;">
      <strong class="me-auto">Veterinaria maldonado</strong>
      <small></small>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      papas
      <?php echo $Error ?>
    </div>
  </div>

</div>

</div>
    </main>
  </form>

</div>

<?php if ($Error==true): ?>
  <script src="../JavaScript/Toasts.js"></script>

     <?php else: ?>
<?php endif; ?>


</body>


</html>