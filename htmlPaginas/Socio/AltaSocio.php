<?php
require_once "../../php/config.php";
require_once "../../php/Socio.php";
require_once "../../php/Usuario.php";
if (!isset($_SESSION["Nombre"], $_SESSION["Rol"]) || $_SESSION["Rol"]==="Usuario") {
    header("Location: ../index.php");
    exit();
}

  if (isset($_POST['boton'])) {
    $Ci=($_POST['Ci']);
  $FechaDePago= new DateTime(($_POST['FechaDePago']));
       $Mes=($_POST['Mes']);

    $Usuario= new Usuario($Ci);
if ($Usuario->VerificarCi()=== "El ci ya esta en uso"){
    $Socio= new Socio(null,$FechaDePago);
    $Socio->AltaSocio($Ci, $Mes);
$_SESSION["MensajeToast"] = "Socio agregado correctamente";
} else {
    $_SESSION["Mensaje"] ="El Ci no esta registrado";
}
header("Location: " . $_SERVER['PHP_SELF']);
exit();


  }

  if (isset($_POST['botonClose'])) {
   CerrarSesion();
   header("Location: ../index.php");
    exit();
}

?>
<?php
$MensajeToast = $_SESSION["MensajeToast"] ?? "";

unset($_SESSION["MensajeToast"]);
?>
<!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/interfaz.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <title>Agregar socio</title>
    <link rel="icon" type="image/png" href="../../archivos.img/LogoTransparente.png">
  </head>
<body class="d-flex flex-column vh-100"
      style="background-color: #282626; color: #ffffff;">

    <!-- ENCABEZADO -->
<header class="mx-0 flex-shrink-0">

    <!-- PRIMERA FILA -->
    <div class="row">

        <!-- USUARIO Y ROL -->
        <section class="col-12 col-md-4">
          <h2><?= htmlspecialchars($_SESSION["Nombre"], ENT_QUOTES, 'UTF-8') ?></h2>
          <p><?= htmlspecialchars($_SESSION["Rol"], ENT_QUOTES, 'UTF-8') ?></p>
        </section>



        <!-- OPCIONES -->
        <div class="offset-md-4 col-12 col-md-4 d-flex justify-content-md-end align-items-center">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle"
                        type="button"
                        id="dropdownMenuButton"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                    Opciones
                </button>

                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <li>
                     <form method="post" action="">
        <button name="botonClose" class="dropdown-item" type="submit">
            Cerrar sesión
        </button>
    </form>
                    </li>
                    <li>
                        <a class="dropdown-item" href="../index.php">Menu principal</a>
                    </li>
                </ul>
            </div>
        </div>

    </div>

    <!--SEGUNDA FILA-->
  <section class="row">
     <!-- TÍTULO -->
        <div class="col-12 d-flex justify-content-center align-items-center">
            <h2>Socios</h2>
        </div>
  </section>
    <!-- TERCERA FILA -->
    <div class="row">


        <section class="col-12 col-md-4 offset-md-4 text-center">
<h2>Agregar Socio</h2>

        </section>


    </div>

</header>




    <hr class="m-0">

    <!-- CONTENEDOR INFERIOR -->
    <div class="d-flex vh-100">

        <!-- MENÚ LATERAL -->
        <div>
            <ul class="nav flex-column h-100">
                <li class="nav-item">
                    <a class="nav-link" href="#">Citas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Ventas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./ListarSocio.php">Membresías</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../Mascota/ListarMascota.php">Mascotas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Alertas</a>
                </li>
                <?php if($_SESSION["Rol"]==="Administrador"){?>
                <li class="nav-item">
                    <a class="nav-link" href="../Usuario/ListarUsuario.php">Usuarios</a>
                </li>
                <?php } ?>
            </ul>
        </div>

        <div class="vr"></div>

          <form  method="post" class="overflow-auto" action="">
      <main class="row flex-grow-1 h-100 align-content-start">
    <section class="col-6 mb-3">
      <label for="Ci" class="form-label">Ci</label>
      <input name="Ci" type="number" inputmode="numeric" pattern="[0-9]{8}" class="form-control" id="Ci" placeholder="Ej: 56573322" required>
    </section>

    <section class="col-6 mb-3">
      <label for="Cierre" class="form-label">fecha de cierre</label>
      <input name="FechaDePago" type="date" class="form-control" id="Cierre" placeholder="Ej: 21/07/2000" required>
    </section>

      <section class="col-6 mb-3">
      <label for="Mes" class="form-label">Meses de Socio</label>
      <input name="Mes" type="number" class="form-control" id="Meses" placeholder="" required>
    </section>


          <section class="col-12 mb-6">
        <input class="btn btn-secondary mb-3" type="reset" value="Resetear valores" required>
        </section>
         <section class="col-12">
        <input  name="boton" class="btn btn-success mb-3" type="submit" value="agregar usuario" id="liveToastBtn" required>
        </section>
        <section class="col-6 mb-6">
       <a href="./ListarSocio.php" class="btn btn-danger" role="button">Salir</a>
        </section>




    </main>
    </form>
    </div>
     <!--TOAST-->
  <div class="toast-container position-fixed bottom-0 end-0 p-3">

    <div id="liveToast"
         class="toast"
         data-mostrar="<?= $MensajeToast !== "" ? 'true' : 'false' ?>"
         role="alert"
         aria-live="assertive"
         aria-atomic="true">

        <div class="toast-header">
            <strong class="me-auto">Veterinaria</strong>

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="toast"
                    aria-label="Close">
            </button>
        </div>

        <div class="toast-body bg-success text-white">
            <?= htmlspecialchars($MensajeToast, ENT_QUOTES, 'UTF-8') ?>
        </div>

    </div>

</div>
<script src="../../JavaScript/Interfaz.js"></script>
</body>
  </html>