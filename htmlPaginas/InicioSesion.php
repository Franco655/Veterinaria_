  <?php
  //INICIA el arreglo SESSION para mantenerlo
  session_start();
  require_once "../php/Login.php";
  $Nombre ="";
  $Contraseña="";
  $resultado =false;
  if (isset($_POST['boton'])) {
    $Nombre = ($_POST['Nombre']);
    $Contraseña = ($_POST['Contrasena']);

    $resultado = (new Login($Nombre, $Contraseña))->Validar();


    if ($resultado == true) {
    // UNA COOKIE QUE GUARDA LA INFORMACIÓN
    // Nota: $_SESSION no es una cookie, es una sesión. Asegúrate de tener session_start(); al inicio del archivo.
    $_SESSION["Nombre"] = $Nombre;
    header("Location: https://google.com");
    exit();
} else {
    // CORREGIDO: Se añadió "Location: "
    //header("Location: https://es.wikipedia.org/wiki/Anime");
    exit();
}


  }
  ?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/InicioASesion.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <title>Inicio a Sesión</title>
  </head>

  <body>
    <main>
      <form method="post" action="">
        <section class="row">
          <section class="col">
            <h1>Veterinaria maldonado</h1>
          </section>
        </section>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">
            <h4>Nombre de usuario</h4>
          </label>
          <input name="Nombre" type="text" class="form-control" id="exampleInputEmail1">
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">
            <h4>Contraseña</h4>
          </label>
          <input name="Contrasena" type="password" class="form-control" id="exampleInputPassword1">
        </div>
        <button name="boton" type="submit" class="btn btn-primary">Iniciar sesión</button>
        <p>
        <h4>¿No tienes cuenta?</h4><a href="Registrarse.html" class="create-account">Crea una</a></p>
        <p> <?php echo $resultado  ?></p>
      </form>
    </main>




  </body>

  </html>