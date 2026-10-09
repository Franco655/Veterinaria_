<?php
  require_once "../php/config.php";
  require_once "../php/Usuario.php";
  require_once "../php/EnviarCorreo.php";

  if (isset($_POST["Cancelar"])) {
    $_SESSION["Verificacion"] = false;
    unset($_SESSION["MensajeValidar"]);
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
}
  if (!isset($_SESSION["Verificacion"])) {
    $_SESSION["Verificacion"] = false;
}
  if (isset($_POST['boton'])) {
    $Mail = ($_POST['Mail']);
    $Usuario = new Usuario(null, null, null, $Mail);
    $Validar=$Usuario->VerificarGmail();
if ($Validar){

  $_SESSION["Verificacion"]=true;
  $Codigo = random_int(1000000, 9999999);
if (EnviarCorreo($Mail, (string) $Codigo)) {
    $_SESSION["Codigo"] = (string) $Codigo;

}
   header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$_SESSION["MensajeValidar"] ="No se encontro el correo electronico";

header("Location: " . $_SERVER['PHP_SELF']);
exit();
  }

    if (isset($_POST['Reenviar'])) {

    }
      if (isset($_POST['botonMail'])) {
        $Codigo = ($_POST['codigo']);

        if (isset($_SESSION["Codigo"]) && $Codigo === $_SESSION["Codigo"]) {
            $_SESSION["Verificacion"] = false;
            unset($_SESSION["Codigo"]);
            header("Location: CambiarContrasena.php");
            exit();
        } else {
            $_SESSION["MensajeValidar"] = "Código incorrecto";
            header("Location: " . $_SERVER['PHP_SELF']);
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
    <link rel="icon" type="image/png" href="../archivos.img/LogoTransparente.png">
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

<?php if(isset($_SESSION["Verificacion"]) && $_SESSION["Verificacion"] === true) { ?>

 <div class="col-12 mb-3 text-center">
          <label for="exampleInputEmail1" class="form-label">
            <h4>Escribe el numero que te llego al correo</h4>
          </label>
          <input name="Codigo" type="text" class="form-control" id="exampleInputEmail1" required>
        </div>

        <div class="col-12">
        <button name="botonMail" type="submit" class="btn btn-primary mb-2">Confirmar</button>
        </div>



        <div class="col-12">
        <button name="Reenviar" type="submit" class="btn btn-primary">reenviar codigo</button>
        </div>

         <div class="col-12">

        <button name="Cancelar" type="submit" formnovalidate class="btn btn-danger mt-2">Cancelar y retroceder</button>
        </div>

        <?php }else{?>

         <div class="col-12 mb-3 text-center">
          <label for="exampleInputEmail1" class="form-label">
            <h4>Escribe tu correo electrónico</h4>
          </label>
          <input name="Mail" type="email" class="form-control" id="exampleInputEmail1" required>
        </div>


        <div class="col-12">
        <button name="boton" type="submit" class="btn btn-primary">Confirmar Mail</button>
        </div>

         <div class="col-12">
        <a href="./index.php" class="btn btn-danger mt-2">Salir</a>
        </div>
        <?php }?>
         </section>

      </form>





  </body>

  </html>