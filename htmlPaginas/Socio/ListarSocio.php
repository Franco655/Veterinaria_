
  <?php
require_once "../../php/config.php";
require_once "../../php/Socio.php";

if (!isset($_SESSION["Nombre"], $_SESSION["Rol"]) || $_SESSION["Rol"]==="Usuario") {
    header("Location: ../index.php");
    exit();
}


$Socio = new Socio();
$busqueda = $_GET["Busqueda"] ?? "";
$Filtro=$_GET["Filtro"]??"";
if ($busqueda != "" || $Filtro!=="") {
    $Socios = $Socio->BuscarSocios($busqueda, $Filtro);
} else {
    $Socios = $Socio->ListarSocio();
}




if (isset($_POST['boton'])) {
$IdMembresia=($_POST['IdMembresia']);
$Socio= new Socio($IdMembresia);
$SocioConsulta=$Socio->ConsultarSocio();
$_SESSION["Socio"]=$SocioConsulta;
header("Location: ModificarSocio.php");
  }
if (isset($_POST['botonClose'])) {
  CerrarSesion();
   header("Location: ../index.php");
    exit();
}
if (isset($_POST['botonDelete'])) {

$IdMembresia=($_POST['IdDelete']);
$Socio= new Socio($IdMembresia);
$Socio->EliminarSocio();
header("Location: " . $_SERVER['PHP_SELF']);
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
    <title>Socios</title>
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

<form method="get" class="row align-items-center mb-3">

    <!-- LIMPIAR -->
    <section class="col-3">
        <a class="btn btn-primary" href="./ListarSocio.php">Limpiar</a>

        <!-- DROPDOWN -->
       <div class="dropdown d-inline-block">

    <button
        class="btn btn-secondary dropdown-toggle"
        type="button"
        data-bs-toggle="dropdown"
        aria-expanded="false" data-bs-auto-close="false">
        Opciones
    </button>

    <ul class="dropdown-menu p-3 bg-dark text-white">

        <li>
            <div class="form-check">
                <input
                    class="form-check-input"
                    type="radio"
                    name="Filtro"
                    value=""
                    id="indefinido"
                    checked>

                <label class="form-check-label" for="indefinido">
                    (Indefinido)
                </label>
            </div>
        </li>

        <li>
            <div class="form-check">
                <input
                    class="form-check-input"
                    type="radio"
                    name="Filtro"
                    value="Cerca"

                    id="cerca">

                <label class="form-check-label" for="cerca">
                    Más cerca de vencimiento
                </label>
            </div>
        </li>

        <li>
            <div class="form-check">
                <input
                    class="form-check-input"
                    type="radio"
                    name="Filtro"
                    value="Lejos";
                    id="lejos">

                <label class="form-check-label" for="lejos">
                    Más lejos de vencimiento
                </label>
            </div>
        </li>

        <li>
            <div class="form-check">
                <input
                    class="form-check-input"
                    type="radio"
                    name="Filtro"
                    value="Vencidos"
                    id="vencidos">

                <label class="form-check-label" for="vencidos">
                    Ya vencidos
                </label>
            </div>
        </li>

    </ul>
</div>
    </section>

    <!-- BÚSQUEDA -->
    <div class="col-12 col-md-6 mb-2 mb-md-0">
        <div class="input-group mx-auto" style="max-width: 450px;">
            <input
                type="search"
                name="Busqueda"
                class="form-control"
                placeholder="Buscar..."
                value="<?= htmlspecialchars($_GET["busqueda"] ?? "", ENT_QUOTES, 'UTF-8') ?>">

            <button type="submit" class="btn btn-primary">
                Buscar
            </button>
        </div>
    </div>

    <!-- AGREGAR SOCIO -->
    <div class="col-12 col-md-3 text-md-end">
        <a
            class="btn btn-success"
            href="AltaSocio.php">
            Agregar Socio
        </a>
    </div>

</form>




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
                 <li class="nav-item">
                    <a class="nav-link" href="../Producto/ListarProducto.php">Productos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="">Proveedor</a>
                </li>
                <?php if($_SESSION["Rol"]==="Administrador"){?>
                <li class="nav-item">
                    <a class="nav-link" href="../Usuario/ListarUsuario.php">Usuarios</a>
                </li>
                <?php } ?>
            </ul>
        </div>

        <div class="vr"></div>

        <main class="overflow-auto flex-grow-1">
<div class="table-responsive">
    <table class="table table-striped table-hover table-bordered align-middle">

        <thead class="table-dark">
            <tr>
                <th>Id de membresia</th>
                <th>Ci</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Fecha de pago</th>
                <th>Fecha de cierre</th>
                 <th>Modificar</th>
                <th>Eliminar</th>
            </tr>
        </thead>

        <tbody>

          <?php foreach ($Socios as $Socio): ?>

    <tr>

        <td><?= htmlspecialchars($Socio["IdMembresia"]) ?></td>
        <td><?= htmlspecialchars($Socio["Ci"]) ?></td>
        <td><?= htmlspecialchars($Socio["Nombre"]) ?></td>
        <td><?= htmlspecialchars($Socio["Apellido"]) ?></td>
        <td><?= htmlspecialchars($Socio["FechaDePago"]) ?></td>
       <td class="<?= new DateTime($Socio["FechaDeCierre"]) < new DateTime() ? 'text-danger' : '' ?>">
    <?= htmlspecialchars($Socio["FechaDeCierre"]) ?>
</td>

        <td>
            <form action="" method="post">

                <input type="hidden"
                       name="IdMembresia"
                       value="<?= htmlspecialchars($Socio["IdMembresia"])?>">

                <button type="submit" name="boton" class="btn btn-primary justify-content-center">Actualizar membresia</button>

            </form>
        </td>
       <td>
    <button
        type="button"
        class="btn btn-danger"
        data-bs-toggle="modal"
        data-bs-target="#exampleModal"
        data-ci="<?= htmlspecialchars($Socio['IdMembresia'], ENT_QUOTES, 'UTF-8') ?>"
        data-nombre="<?= htmlspecialchars($Socio['Nombre'], ENT_QUOTES, 'UTF-8') ?>">
        Eliminar Socio
    </button>
</td>

    </tr>

<?php endforeach; ?>

        </tbody>

    </table>
</div>
        </main>

   <!-- Modal para eliminar usuario -->
<div class="modal fade" id="exampleModal" tabindex="-1"
     aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Eliminar usuario
                </h5>

                <button type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Cerrar">
                </button>
            </div>

            <div class="modal-body">
                ¿Estás seguro de que querés eliminar a
                <strong id="nombreUsuario"></strong>?
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">
                    Cancelar
                </button>

                <form action="" method="POST">
    <input name="IdDelete" type="hidden" id="CiDelete">

    <button name="botonDelete" type="submit" class="btn btn-danger">
        Eliminar
    </button>
</form>
            </div>

        </div>
    </div>
</div>
<script src="../../JavaScript/Interfaz.js"></script>
</body>
  </html>