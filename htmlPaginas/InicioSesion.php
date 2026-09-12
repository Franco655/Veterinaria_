  <?php
  //INICIA el arreglo SESSION para mantenerlo
  session_start();
  require_once "../php/LogicaUsuario.php";
  if (isset($_POST['boton'])) {
    $email = ($_POST['email']);
    $pass = ($_POST['pass']);

    $resultado = (new LoginUser())->AltaLoginvalidar($email, $pass);

    if ($resultado == true) {
      $respuesta = "ingresaste correctamente";
      //UNA COOKIE QUE GUARDA LA INFORMACIÓN
      $_SESSION["username"] = $email;
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
            <h4>Email</h4>
          </label>
          <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">
            <h4>Contraseña</h4>
          </label>
          <input name="pass" type="password" class="form-control" id="exampleInputPassword1">
        </div>
        <button name="boton" type="submit" class="btn btn-primary">Iniciar sesión</button>
        <p>
        <h4>¿No tienes cuenta?</h4><a href="Registrarse.html" class="create-account">Crea una</a></p>

      </form>
    </main>




  </body>

  </html>