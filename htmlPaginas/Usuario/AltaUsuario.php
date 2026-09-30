<?php
require_once "../../php/config.php";
require_once "../../php/LogicaUsuario.php";
require_once "../../php/Login.php";
if (!isset($_SESSION["Nombre"], $_SESSION["Rol"]) || $_SESSION["Rol"] !=="Administrador") {
    header("Location: ../index.php");
    exit();
}

  if (isset($_POST['boton'])) {
    $Ci=($_POST['Ci']);
    $Nombre=($_POST['Nombre']);
    $Apellido = ($_POST['Apellido']);
    $Mail=($_POST['Mail']);
    $Direccion=($_POST['Direccion']);
    $Telefono=($_POST['Telefono']);
    $UsserName=($_POST['NombreDeUsuario']);
    $Contrasena=($_POST['Contrasena']);
    $Rol=($_POST['Rol']);
      $Usuario = new Usuario($Ci, $Nombre, $Apellido, $Mail, $Direccion, $Telefono, $Rol);
      $Login = new login($UsserName, $Contrasena);

$Verificacion=$Usuario->VerificarCi();
$VerificacionLogin=$Login->VerificarUsuario();
if ($Verificacion !== "" || $VerificacionLogin !== "") {

    $_SESSION["MensajeLogin"] = $VerificacionLogin;
    $_SESSION["Mensaje"] = $Verificacion;

} else {
$Usuario->AltaUsuario();
    $Login->AltaLogin($Ci);

    $_SESSION["MensajeToast"] = "Usuario agregado correctamente";
}

header("Location: " . $_SERVER['PHP_SELF']);
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
   header("Location: index.php");
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
                        <a class="dropdown-item" href="./index.php">Menu principal</a>
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
    <div class="row">


        <section class="col-12 col-md-4 offset-md-4 text-center">
<h2>Agregar Usuario</h2>

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

          <form  method="post" class="overflow-auto" action="">
      <main class="row flex-grow-1 h-100 align-content-start">
    <section class="col-6 mb-3">
      <label for="Ci" class="form-label">Ci</label>
      <input name="Ci" type="number" inputmode="numeric" pattern="[0-9]{8}" class="form-control" id="Ci" placeholder="Ej: 56573322" required>
    </section>

    <section class="col-6 mb-3">
      <label for="Mail" class="form-label">Mail</label>
      <input name="Mail" type="email" class="form-control" id="Mail" placeholder="Ej: papas@gmail.com" required>
    </section>

      <section class="col-6 mb-3">
      <label for="Nombre" class="form-label">Nombre</label>
      <input name="Nombre" type="text" class="form-control" id="Nombre" placeholder="" required>
    </section>

      <section class="col-6 mb-3">
      <label for="Apellido" class="form-label">Apellido</label>
      <input name="Apellido" type="text" class="form-control" id="Apellido" placeholder="" required>
    </section>

      <section class="col-6 mb-3">
      <label for="Numero" class="form-label">Telefono</label>
      <input name="Telefono" type="number" class="form-control" id="Numero" placeholder="Ej: 093899890" required>
    </section>

    <section class="col-6 mb-3">
      <label for="Direccion" class="form-label">Dirección</label>
      <input name="Direccion" type="text" class="form-control" id="Direccion" placeholder="Santana 654" required>
    </section>

        <section class="col-6 mb-3">
        <label for="" class="form-label">Rol</label>
        <select name="Rol" id="" class="form-select">
          <option value="Empleado">Empleado</option>
          <option value="Usuario">usuario</option>
          <option value="Administrador">Administrador</option>
        </select>
        </section>


 <section class="col-6">
        <label for="InputContrasena" class="form-label">Contraseña</label>
        <input name="Contrasena" type="password" class="form-control" id="InputContrasena" required>
 </section>
 <section class="col-12">
        <label for="InputUsser" class="form-label">NombreDeUsuario</label>
        <input name="NombreDeUsuario" type="text" class="form-control" id="InputUsser" required>
 </section>
  <?php if (!empty($_SESSION["Mensaje"])) { ?>
    <div class="col-12 text-danger text-center mb-3">
        <?= htmlspecialchars($_SESSION["Mensaje"]) ?>
        <?php unset($_SESSION["Mensaje"]); ?>
    </div>
<?php } ?>

<!-- Mensaje específico del Login / Cuenta -->
<?php if (!empty($_SESSION["MensajeLogin"])) { ?>
    <div class="col-12 text-danger text-center mb-3">
        <?= htmlspecialchars($_SESSION["MensajeLogin"]) ?>
        <?php unset($_SESSION["MensajeLogin"]); ?>
    </div>
<?php } ?>
          <section class="col-12 mb-6">
        <input class="btn btn-secondary mb-3" type="reset" value="Resetear valores" required>
        </section>
         <section class="col-12">
        <input  name="boton" class="btn btn-success mb-3" type="submit" value="agregar usuario" id="liveToastBtn" required>
        </section>
        <section class="col-6 mb-6">
       <a href="./ListarUsuario.php" class="btn btn-danger" role="button">Salir</a>
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