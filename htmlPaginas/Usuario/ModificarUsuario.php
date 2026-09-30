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
    $Rol=($_POST['Rol']);
      $Usuario = new Usuario($Ci, $Nombre, $Apellido, $Mail, $Direccion, $Telefono, $Rol);
      $Login = new login($UsserName);

$Verificacion=$Usuario->VerificarCi($_SESSION["Usuario"]["Ci"]);
$VerificacionLogin=$Login->VerificarUsuario($_SESSION["Usuario"]["NombreDeUsuario"]);
if ($Verificacion !== "" || $VerificacionLogin !== "") {

    $_SESSION["MensajeLogin"] = $VerificacionLogin;
    $_SESSION["Mensaje"] = $Verificacion;

} else {
$CiAnterior=$_SESSION["Usuario"]["Ci"];
    $Usuario->ModificarUsuario($CiAnterior);
    $Login->ModificarLogin($Usuario->getCi());
    $_SESSION["MensajeToast"] = "Usuario modificado correctamente correctamente";
}
unset($_SESSION["Usuario"]);
header("Location: ./ListarUsuario.php");
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
    <div class="row">


        <section class="col-12 col-md-4 offset-md-4 text-center">
<h2>Modificar Usuario</h2>

        </section>
         <!-- AGREGAR USUARIO -->
    <div class="col-12 col-md-3 text-md-end">
        <a
            class="btn btn-success"
            href="AltaUsuario.php">
            Agregar Usuario
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

          <form method="post" class="overflow-auto" action="">
     <main class="row align-content-start">
    <section class="col-6 mb-3">
      <label for="Ci" class="form-label">Ci</label>
      <input name="Ci" value="<?= htmlspecialchars($_SESSION["Usuario"]["Ci"]) ?>" type="number" class="form-control" id="Ci" placeholder="Ej: 56573322" required>
      <div  class="form-text d-flex text-light">
        <p style="display: flex;">Ci anterior:&nbsp</p><p><?= htmlspecialchars($_SESSION["Usuario"]["Ci"]) ?></p></div>
    </section>

    <section class="col-6 mb-3">
      <label for="Gmail" class="form-label">Gmail</label>
      <input name="Mail" value="<?= htmlspecialchars($_SESSION["Usuario"]["Mail"]) ?>" type="email" class="form-control" id="Gmail" placeholder="Ej: papas@gmail.com" required>
      <div class="form-text d-flex text-light">
        <p style="display: flex;">Gmail anterior anterior:&nbsp</p><p><?= htmlspecialchars($_SESSION["Usuario"]["Mail"]) ?></p></div>
    </section>

      <section class="col-6 mb-3">
      <label for="Nombre" class="form-label">Nombre</label>
      <input name="Nombre" value="<?= htmlspecialchars($_SESSION["Usuario"]["Nombre"]) ?>" type="text" class="form-control" id="Nombre" placeholder="" required>
       <div  class="form-text d-flex text-light">
        <p style="display: flex;">Nombre anterior:&nbsp</p><p><?= htmlspecialchars($_SESSION["Usuario"]["Nombre"]) ?></p></div>
    </section>

      <section class="col-6 mb-3">
      <label for="Apellido" class="form-label">Apellido</label>
      <input name="Apellido"  value="<?= htmlspecialchars($_SESSION["Usuario"]["Apellido"]) ?>" type="text" class="form-control" id="Apellido" placeholder="" required>
      <div  class="form-text d-flex text-light">
        <p  class="text-light" style="display: flex;">Apellido&nbspanterior:&nbsp</p><p><?= htmlspecialchars($_SESSION["Usuario"]["Apellido"]) ?></p></div>
    </section>

      <section class="col-6 mb-3">
      <label for="Numero" class="form-label">Telefono</label>
      <input name="Telefono" value="<?= htmlspecialchars($_SESSION["Usuario"]["Telefono"]) ?>" type="number" class="form-control" id="Numero" placeholder="Ej: 093899890" required>
      <div  class="form-text d-flex text-light">
        <p style="display: flex;">Telefóno anterior:&nbsp</p><p><?= htmlspecialchars($_SESSION["Usuario"]["Telefono"]) ?></p></div>
    </section>

    <section class="col-6 mb-3">
      <label for="Direccion" class="form-label">Dirección</label>
      <input name="Direccion" value="<?= htmlspecialchars($_SESSION["Usuario"]["Direccion"]) ?>" type="text" class="form-control" id="Direccion" placeholder="Santana 654" required>
      <div  class="form-text d-flex  text-light">
        <p class="text-light" tyle="display: flex;">Dirección anterior:&nbsp</p><p><?= htmlspecialchars($_SESSION["Usuario"]["Direccion"]) ?></p></div>
    </section>




        <section class="col-6 mb-3">
<label for="Rol" class="form-label">Rol</label>
<select name="Rol" class="form-select" id="Rol">
    <?php if ($_SESSION["Usuario"]["Rol"] === "Administrador"): ?>

        <option value="Administrador">Administrador</option>
        <option value="Empleado">Empleado</option>
        <option value="Usuario">Usuario</option>

    <?php elseif ($_SESSION["Usuario"]["Rol"] === "Empleado"): ?>

        <option value="Empleado">Empleado</option>
        <option value="Administrador">Administrador</option>
        <option value="Usuario">Usuario</option>

    <?php else: ?>

        <option value="Usuario">Usuario</option>
        <option value="Administrador">Administrador</option>
        <option value="Empleado">Empleado</option>

    <?php endif; ?>

</select>
  <div  class="form-text d-flex text-light">
        <p style="display: flex;">Rol anterior:&nbsp</p><p><?= htmlspecialchars($_SESSION["Usuario"]["Rol"]) ?></p></div>
        </section>

          <section class="col-6 mb-3">
      <label for="Direccion" class="form-label">NombreDeUsuario</label>
      <input name="NombreDeUsuario" value="<?= htmlspecialchars($_SESSION["Usuario"]["NombreDeUsuario"]) ?>" type="text" class="form-control" id="Direccion" placeholder="Santana 654" required>
      <div  class="form-text d-flex  text-light">
        <p class="text-light" tyle="display: flex;">Nombre&nbspde&nbspusuario&nbspanterior:&nbsp</p><p><?= htmlspecialchars($_SESSION["Usuario"]["NombreDeUsuario"]) ?></p></div>
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
       </section>
         <section class="col-12">
        <input  name="boton" class="btn btn-success mb-3" type="submit" value="Modificar usuario" id="liveToastBtn" required>
        </section>

         <section class="col-12 mb-6">
        <input class="btn btn-secondary mb-3" type="reset" value="Resetear valores">
        </section>

        <section class="col-12 mb-6">
       <a href="./ListarUsuario.php" class="btn btn-danger" role="button">Salir</a>
        </section>








    </main>
    </form>
    </div>

</body>
</html>