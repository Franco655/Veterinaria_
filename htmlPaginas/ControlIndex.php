  <?php
require_once "../php/config.php";
if (!isset($_SESSION["Nombre"], $_SESSION["Rol"]) || $_SESSION["Rol"]=== "Usuario") {
    header("Location: ../index.php");
    exit();
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
   header("Location: ./index.php");
    exit();
}


?>

  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/interfaz.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <title>Panel de control</title>
     <link rel="icon" type="image/png" href="../archivos.img/LogoTransparente.png">
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
                        <a class="dropdown-item" href="./index.php">Menu principal</a>
                    </li>
                </ul>
            </div>
        </div>

    </div>






</header>





    <hr class="m-0">

    <!-- CONTENEDOR INFERIOR -->
    <div class="d-flex flex-grow-1">

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
                    <a class="nav-link" href="./Socio/ListarSocio.php">Membresías</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./Mascota/ListarMascota.php">Mascotas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Clientes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Alertas</a>
                </li>
                <?php if($_SESSION["Rol"]==="Administrador"){?>
                <li class="nav-item">
                    <a class="nav-link" href="./Usuario/ListarUsuario.php">Usuarios</a>
                </li>
                <?php } ?>
            </ul>
        </div>

        <div class="vr"></div>

        <main class="overflow-auto flex-grow-1">

        </main>

    </div>

</body>
  </html>
