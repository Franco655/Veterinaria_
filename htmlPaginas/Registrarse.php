<?php
require_once "LoginUser";
if (isset($_POST['boton'])) {
  $username = ($_POST['username']);
  $pass = ($_POST['pass']);

  $resultado = (new LoginUser())->validar($username, $pass);

  if ($resultado == true) {
    session_start();
    $respuesta = "ingresaste correctamente";
    $_SESSION["username"] = $username;
    header("Location: index.php");
  } else {
    $respuesta = "Error al ingresar";
  }
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
  <form action="." method="post">
    <main class="row g-2 align-items-center">
      <div class="col-6">
        <h1>Veterinaria maldonado</h1>
      </div>
      <div class="col-6">
        <h3>registrarse</h3>
      </div>
      <div class="col-md-6">
        <label for="InputNombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="InputNombre">
      </div>
      <div class="col-md-6">
        <label for="InputApellido" class="form-label">Apellido</label>
        <input type="text" class="form-control" id="InputApellido">
      </div>
      <div class="col-6">
        <label for="InputMail" class="form-label">Mail</label>
        <input type="text" class="form-control" id="InputMail">
      </div>
      <div class="col-6">
        <label for="InputContrasena" class="form-label">Contraseña</label>
        <input type="password" class="form-control" id="InputContrasena">
      </div>
      <div class="col-md-6">
        <label for="InputUsuario" class="form-label">Nombre de Usuario</label>
        <input type="text" class="form-control" id="InputUsuario">
      </div>
      <div class="col-6">
        <label for="InputTel" class="form-label">Telefóno</label>
        <input type="text" class="form-control" id="InputTel">
      </div>
      <div class="col-6">
        <label for="InpuCi" class="form-label">Cedula</label>
        <input type="number" class="form-control" id="InputCi">
      </div>
      <div class="col-12">
        <button type="submit" class="btn btn-primary">registrarse</button>
      </div>
    </main>
  </form>



</body>

</html>