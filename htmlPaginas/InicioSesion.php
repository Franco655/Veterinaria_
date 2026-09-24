<?php
  require_once "../php/config.php";
  require_once "../php/Login.php";
  if (isset($_POST['boton'])) {
    $Nombre = ($_POST['Nombre']);
    $Contraseña = ($_POST['Contrasena']);

    if(($Validar=new Login($Nombre, $Contraseña))->Validar()!==""){
      $_SESSION["Rol"]=$Validar;
       $_SESSION["Nombre"] = $Nombre;
       header("Location: index.php");
       exit();
    }
    $_SESSION["MensajeValidar"]="Nombre de usuario o contraseña incorrectos";
     header("Location: " . $_SERVER['PHP_SELF']);
    exit();

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

      <form class="shadow-lg" method="post" action="">

        <section class="row">
          <div class="col-12 mb-5">
            <img src="../archivos.img/LogoVeterinaria.jpeg" alt="">

        </div>

         <?php if (!empty($_SESSION["MensajeValidar"])) { ?>
    <div class="col-12 text-danger text-center mb-3">
        <?= htmlspecialchars($_SESSION["MensajeValidar"]) ?>
        <?php unset($_SESSION["MensajeValidar"]); ?>
    </div>
<?php } ?>

        <div class="col-12 mb-3">
          <label for="exampleInputEmail1" class="form-label">
            <h4>Nombre de usuario</h4>
          </label>
          <input name="Nombre" type="text" class="form-control" id="exampleInputEmail1"required>
        </div>
        <div class="col-12 mb-3">
          <label for="exampleInputPassword1" class="form-label">
            <h4>Contraseña</h4>
          </label>
          <input name="Contrasena" type="password" class="form-control" id="exampleInputPassword1" required>
        </div>
        <div class="col-12">
        <button name="boton" type="submit" class="btn btn-primary">Iniciar sesión</button>
        </div>
        <div class="col-12">
       <a style="text-decoration: none;" href="http://localhost/veterinaria/htmlPaginas/Registrarse.php">Registrarse</a>
        </div>
        <div class="col-12">
          <a style="text-decoration: none;" href="http://localhost/veterinaria/htmlPaginas/Registrarse.php">Recuperar contraseña</a>
        </div>

         </section>

      </form>





  </body>

  </html>