<?php
require_once "../../php/config.php";
require_once "../../php/Socio.php";

if (!isset($_SESSION["Nombre"], $_SESSION["Rol"]) ||$_SESSION["Rol"] === "Usuario") {
    header("Location: ../index.php");
    exit();
}

// Modificar fecha de cierre
if (isset($_POST["boton"])) {
   $FechaDeCierre = new DateTime($_POST["FechaDeCierre"]);
    if ($FechaDeCierre !== "") {
        $IdMembresia = (int)$_SESSION["Socio"]["IdMembresia"];
        $Socio = new Socio($IdMembresia,null,$FechaDeCierre);
       $Socio->ActualizarFechaCierre();
         unset($_SESSION["Socio"]);
            header("Location: ./ListarSocio.php");
            exit();

    }
    $_SESSION["Mensaje"] = "No se pudo actualizar la fecha de cierre";
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
}

// Cerrar sesión
if (isset($_POST["botonClose"])) {
CerrarSesion();
    header("Location: ../index.php");
    exit();
}

$_SESSION["Socio"]["FechaDeCierre"];

?>

  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/interfaz.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <title>Modificar socio</title>
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
<h2>Modificar Socio</h2>

        </section>
         <!-- AGREGAR USUARIO -->
    <div class="col-12 col-md-3 text-md-end">
        <a
            class="btn btn-success"
            href="./AltaSocio.php">
            Agregar Socio
        </a>
    </div>


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

          <form method="post" class="overflow-auto" action="">
     <main class="row align-content-start">
   <section class="col-6 mb-3">

    <label for="FechaDeCierre" class="form-label">
        Actualizar fecha de pago
    </label>
    <input name="FechaDeCierre" value="<?= htmlspecialchars($_SESSION["Socio"]["FechaDePago"], ENT_QUOTES, 'UTF-8') ?>" type="date" class="form-control" id="FechaDeCierre" required>

    <div class="form-text text-light">
        Fecha de cierre anterior:
        <?= htmlspecialchars($_SESSION["Socio"]["FechaDeCierre"], ENT_QUOTES, 'UTF-8') ?>
    </div>

</section>

<section class="col-12 mb-3">
    <button
        name="boton"
        class="btn btn-success"
        type="submit"
    >
        Modificar fecha
    </button>
</section>

<section class="col-12 mb-3">
    <input
        class="btn btn-secondary"
        type="reset"
        value="Restablecer valores"
    >
</section>

<section class="col-12 mb-3">
    <a
        href="./ListarSocio.php"
        class="btn btn-danger"
        role="button"
    >
        Salir
    </a>
</section>








    </main>
    </form>
    </div>

</body>
</html>