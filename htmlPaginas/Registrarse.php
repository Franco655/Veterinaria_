


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
        <input name="Telefóno" type="text" class="form-control" id="InputTel">
      </div>
      <div class="col-6">
        <label for="InpuCi" class="form-label">Cedula</label>
        <input name="Ci" type="number" class="form-control" id="InputCi">
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
        <input name="pass" type="password" class="form-control" id="InputContrasena">
      </div>



        <div class="col-12">
        <button type="submit" class="btn btn-primary">registrarse</button>
      </div>
              <div class="col-12">
        <button type="submit" class="btn btn-danger">Cancelar</button>


      </div>
      <div class="col-12">
                <input class="btn btn-secondary" type="reset" value="Resetear valores">
      </div>
    </main>
  </form>


<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <img src="..." class="rounded me-2" alt="...">
      <strong class="me-auto">Bootstrap</strong>
      <small>11 mins ago</small>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      Hello, world! This is a toast message.
    </div>
  </div>
</div>
</body>


</html>