<?php

require_once "../../php/config.php";
require_once "../../php/Mascota.php";
VerificarSesion();

// Modificar fecha de cierre
if (isset($_POST["boton"])) {

 $Nombre=($_POST['Nombre']);
    $Raza=($_POST['Raza']);
  $Nacimiento= new DateTime(($_POST['Nacimiento']));
  $Castrado=($_POST['Castrado']);
       $Peso=($_POST['Peso']);

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

?>

  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/interfaz.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <title>Modificar mascota</title>
    <link rel="icon" type="image/png" href="../../archivos.img/LogoVeterinariaSinLetra.jpeg">
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
            <h2>Mascotas</h2>
        </div>
  </section>
    <!-- TERCERA FILA -->
    <div class="row">


        <section class="col-12 col-md-4 offset-md-4 text-center">
<h2>Modificar Mascota</h2>

        </section>
         <!-- AGREGAR USUARIO -->
    <div class="col-12 col-md-3 text-md-end">
        <a
            class="btn btn-success"
            href="./AltaMascota.php">
            Agregar Mascota
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
                    <a class="nav-link" href="../Socio/ListarSocio.php">Membresías</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./ListarMascota.php">Mascotas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Clientes</a>
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
      <label for="Nombre" class="form-label">Nombre</label>
      <input value="<?= htmlspecialchars($_SESSION["Mascota"]["Nombre"]) ?>" name="Nombre" type="text" class="form-control" id="Nombre" placeholder="" required>
       <div  class="form-text d-flex text-light">
        <p style="display: flex;">Nombre anterior:&nbsp</p><p><?= htmlspecialchars($_SESSION["Mascota"]["Nombre"]) ?></p></div>
    </section>

    <section class="col-6 mb-3">
      <label for="Raza" class="form-label">Raza de la mascota</label>
      <input  value="<?= htmlspecialchars($_SESSION["Mascota"]["Raza"]) ?>" name="Raza" type="text" class="form-control" id="Raza" placeholder="" required>
       <div  class="form-text d-flex text-light">
        <p style="display: flex;">Raza anterior:&nbsp</p><p><?= htmlspecialchars($_SESSION["Mascota"]["Raza"]) ?></p></div>
    </section>

     <section class="col-6 mb-3">
      <label for="Nacimiento" class="form-label">fecha de nacimiento</label>
      <input name="Nacimiento" value="<?= htmlspecialchars($_SESSION["Mascota"]["FechaNacimiento"], ENT_QUOTES, 'UTF-8') ?>" type="date" class="form-control" id="Nacimiento" required>
      <div  class="form-text d-flex text-light">
        <p style="display: flex;">Fecha:&nbspDe:&nbspnacimiento:&nbspanterior:&nbsp</p><p><?= htmlspecialchars($_SESSION["Mascota"]["FechaNacimiento"]) ?></p></div>
    </section>

   <section class="col-6 mb-3">
    <label for="Castrado" class="form-label">Castrado</label>

    <select name="Castrado" id="Castrado" class="form-select">
        <?php if ($_SESSION["Mascota"]["Castrado"] == 1): ?>
            <option value="1" selected>Sí</option>
            <option value="0">No</option>
        <?php else: ?>
            <option value="0" selected>No</option>
            <option value="1">Sí</option>
        <?php endif; ?>
    </select>
     <div  class="form-text d-flex text-light">
        <p style="display: flex;">Castrado anterior:&nbsp;</p>
<p>
    <?= $_SESSION["Mascota"]["Castrado"] == 1 ? "Sí" : "No" ?>
</p></div>
</section>


         <section class="col-6 mb-3">
      <label for="Peso" class="form-label">peso del  animal en kg</label>
      <input value="<?= htmlspecialchars($_SESSION["Mascota"]["Peso"]) ?>" name="Peso" type="number" class="form-control" id="Peso" placeholder="" required>
      <div  class="form-text d-flex text-light">
        <p style="display: flex;">Peso:&nbspanterior:&nbsp</p><p><?= htmlspecialchars($_SESSION["Mascota"]["Peso"]) ?></p></div>
    </section>

  <section class="col-12">
        <input  name="boton" class="btn btn-success mb-3" type="submit" value="Aceptar cambios" id="liveToastBtn" required>
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
        href="./ListarMascota.php"
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