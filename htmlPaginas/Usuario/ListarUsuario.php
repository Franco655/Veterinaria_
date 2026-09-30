  <?php
require_once "../../php/config.php";
require_once "../../php/LogicaUsuario.php";
require_once "../../php/Login.php";
if (!isset($_SESSION["Nombre"], $_SESSION["Rol"]) || $_SESSION["Rol"] !=="Administrador") {
    header("Location: index.php");
    exit();
}


$usuario = new Usuario();
$busqueda = $_GET["Busqueda"] ?? "";
if ($busqueda != "") {
    $usuarios = $usuario->BuscarUsuarios($busqueda);
} else {
    $usuarios = $usuario->ListarUsuario();
}




if (isset($_POST['boton'])) {
$Ci=($_POST['Ci']);
$Usuario= new Usuario($Ci);
$UsuarioConsulta=$Usuario->ConsultarUsuario();
$_SESSION["Usuario"]=$UsuarioConsulta;
header("Location: ModificarUsuario.php");
  }
if (isset($_POST['botonClose'])) {
    // 1. Asegurar que la sesión esté iniciada para poder destruirla
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // 2. Limpiar las variables en memoria
    $_SESSION = [];

    // 3. Destruir la cookie en el navegador (Usando el método moderno)
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', [
            'expires' => time() - 3600,
            'path' => $params["path"],
            'domain' => $params["domain"],
            'secure' => $params["secure"],
            'httponly' => $params["httponly"],
            'samesite' => 'Strict'
        ]);
    }
    // 4. Destruir la sesión en el servidor
    session_destroy();
    // 5. Redirigir para evitar que el usuario recargue la página y reenvíe el formulario
   header("Location: ../index.php");
    exit();
}
if (isset($_POST['botonDelete'])) {

$Ci=($_POST['CiDelete']);
$Usuario= new Usuario($Ci);
$Usuario->EliminarUsuario();
header("Location: " . $_SERVER['PHP_SELF']);

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
    <title>Inicio a Sesión</title>
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
            <h2>Usuarios</h2>
        </div>
  </section>
    <!-- TERCERA FILA -->
    <form  method="get" class="row align-items-center">

<section class="col-3">
    <a class="btn btn-primary" href="./ListarUsuario.php">Limpiar</a>
</section>

    <!-- BÚSQUEDA -->
    <div class="col-12 col-md-6 mb-2 mb-md-0">
        <div class="input-group mx-auto" style="max-width: 450px;">
            <input   type="search" name="Busqueda" class="form-control" placeholder="Buscar..." value="<?= htmlspecialchars($_GET["busqueda"] ?? "", ENT_QUOTES, 'UTF-8') ?>">
            <button type="submit" class="btn btn-primary">
                Buscar
            </button>
        </div>
    </div>

    <!-- AGREGAR USUARIO -->
    <div class="col-12 col-md-3 text-md-end">
        <a
            class="btn btn-success"
            href="AltaUsuario.php">
            Agregar Usuario
        </a>
    </div>

</form>

</header>





    <hr class="m-0">

    <!-- CONTENEDOR INFERIOR -->
    <div class="d-flex vh-100">

        <!-- MENÚ LATERAL -->
        <div class="">
            <ul class="nav flex-column h-100">
                <li class="nav-item">
                    <a class="nav-link" href="#">Citas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Ventas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Membresías</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Animales</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Clientes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Alertas</a>
                </li>
                <?php if($_SESSION["Rol"]==="Administrador"){?>
                <li class="nav-item">
                    <a class="nav-link" href="./ListarUsuario.php">Usuarios</a>
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
                <th>CI</th>
                <th>Nombre</th>
                <th>Nombre de usuario</th>
                <th>Apellido</th>
                <th>Mail</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Rol</th>
                <th></th>
            </tr>
        </thead>

        <tbody>

          <?php foreach ($usuarios as $usuario): ?>

    <tr>

        <td><?= htmlspecialchars($usuario["Ci"]) ?></td>
        <td><?= htmlspecialchars($usuario["Nombre"]) ?></td>
        <td><?= htmlspecialchars($usuario["NombreDeUsuario"]) ?></td>
        <td><?= htmlspecialchars($usuario["Apellido"]) ?></td>
        <td><?= htmlspecialchars($usuario["Mail"]) ?></td>
        <td><?= htmlspecialchars($usuario["Direccion"]) ?></td>
        <td><?= htmlspecialchars($usuario["Telefono"]) ?></td>
        <td><?= htmlspecialchars($usuario["Rol"]) ?></td>

        <td>
            <form action="" method="post">

                <input type="hidden"
                       name="Ci"
                       value="<?= htmlspecialchars($usuario["Ci"]) ?>">

                <button type="submit" name="boton" class="btn btn-primary justify-content-center">Modificar</button>

            </form>
        </td>
       <td>
    <button
        type="button"
        class="btn btn-danger"
        data-bs-toggle="modal"
        data-bs-target="#exampleModal"
        data-ci="<?= htmlspecialchars($usuario['Ci'], ENT_QUOTES, 'UTF-8') ?>"
        data-nombre="<?= htmlspecialchars($usuario['Nombre'], ENT_QUOTES, 'UTF-8') ?>">
        Eliminar Usuario
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
    <input name="CiDelete" type="hidden" id="CiDelete">

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