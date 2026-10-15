<?php
require_once "../../php/config.php";
require_once "../../php/Cita.php";
VerificarAdministrador();

$cita = new Cita();
$mensaje = $_SESSION["Mensaje"] ?? "";
$mensajeToast = $_SESSION["MensajeToast"] ?? "";
unset($_SESSION["Mensaje"], $_SESSION["MensajeToast"]);

if (isset($_POST["boton"])) {
    $ciUsuario = trim($_POST["CiUsuario"] ?? "");
    $idMascota = filter_var($_POST["IdMascota"] ?? null, FILTER_VALIDATE_INT);
    $fecha = $_POST["Fecha"] ?? "";
    $hora = $_POST["Hora"] ?? "";
    $motivo = trim($_POST["Motivo"] ?? "");

    if ($ciUsuario === "" || $idMascota === false || $fecha === "" || $hora === "" || $motivo === "") {
        $_SESSION["Mensaje"] = "Completá todos los campos.";
    } elseif ($fecha < date("Y-m-d")) {
        $_SESSION["Mensaje"] = "La fecha de la cita no puede ser anterior a hoy.";
    } else {
        $fechaCita = DateTime::createFromFormat("Y-m-d", $fecha);
        $citaNueva = new Cita(
            null,
            $fechaCita ?: null,
            "Pendiente",
            $motivo,
            true,
            $hora
        );

        if ($fechaCita !== false && $citaNueva->AltaCita($ciUsuario, $idMascota)) {
            $_SESSION["MensajeToast"] = "Cita agregada correctamente.";
        } else {
            $_SESSION["Mensaje"] = "No se pudo crear la cita. Verificá que la mascota pertenezca al usuario.";
        }
    }
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
}

if (isset($_POST["botonClose"])) {
    CerrarSesion();
    header("Location: ../index.php");
    exit();
}

$usuarios = $cita->ListarUsuariosParaCita();
$mascotas = $cita->ListarMascotasParaCita();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../css/interfaz.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
  <title>Agregar cita</title>
  <link rel="icon" type="image/png" href="../../archivos.img/LogoTransparente.png">
</head>
<body class="d-flex flex-column vh-100" style="background-color: #282626; color: #ffffff;">
<header class="mx-0 flex-shrink-0">
  <div class="row">
    <section class="col-12 col-md-4">
      <h2><?= htmlspecialchars($_SESSION["Nombre"], ENT_QUOTES, "UTF-8") ?></h2>
      <p><?= htmlspecialchars($_SESSION["Rol"], ENT_QUOTES, "UTF-8") ?></p>
    </section>
    <div class="offset-md-4 col-12 col-md-4 d-flex justify-content-md-end align-items-center">
      <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">Opciones</button>
        <ul class="dropdown-menu">
          <li><form method="post"><button name="botonClose" class="dropdown-item" type="submit">Cerrar sesión</button></form></li>
          <li><a class="dropdown-item" href="../index.php">Menu principal</a></li>
        </ul>
      </div>
    </div>
  </div>
  <section class="row"><div class="col-12 d-flex justify-content-center align-items-center"><h2>Citas</h2></div></section>
  <div class="row"><section class="col-12 col-md-4 offset-md-4 text-center"><h2>Agregar cita</h2></section></div>
</header>
<hr class="m-0">
<div class="d-flex vh-100">
  <div>
    <ul class="nav flex-column h-100">
      <li class="nav-item"><a class="nav-link" href="./ListarCita.php">Citas</a></li>
      <li class="nav-item"><a class="nav-link" href="#">Ventas</a></li>
      <li class="nav-item"><a class="nav-link" href="../Socio/ListarSocio.php">Membresías</a></li>
      <li class="nav-item"><a class="nav-link" href="../Mascota/ListarMascota.php">Mascotas</a></li>
      <li class="nav-item"><a class="nav-link" href="#">Alertas</a></li>
      <li class="nav-item"><a class="nav-link" href="../Producto/ListarProducto.php">Productos</a></li>
      <li class="nav-item"><a class="nav-link" href="../Proveedor/ListaProveedor.php">Proveedor</a></li>
      <li class="nav-item"><a class="nav-link" href="../Usuario/ListarUsuario.php">Usuarios</a></li>
    </ul>
  </div>
  <div class="vr"></div>
  <form method="post" class="overflow-auto flex-grow-1" action="">
    <main class="row flex-grow-1 h-100 align-content-start">
      <?php if ($mensaje !== ""): ?><div class="col-12 text-danger text-center mb-3"><?= htmlspecialchars($mensaje, ENT_QUOTES, "UTF-8") ?></div><?php endif; ?>
      <section class="col-6 mb-3"><label for="CiUsuario" class="form-label">Usuario</label>
        <select name="CiUsuario" id="CiUsuario" class="form-select" required><option value="">Seleccionar usuario...</option>
          <?php foreach ($usuarios as $usuario): ?><option value="<?= htmlspecialchars($usuario["Ci"]) ?>"><?= htmlspecialchars($usuario["Nombre"] . " " . $usuario["Apellido"] . " (" . $usuario["Ci"] . ")") ?></option><?php endforeach; ?>
        </select>
      </section>
      <section class="col-6 mb-3"><label for="IdMascota" class="form-label">Mascota</label>
        <select name="IdMascota" id="IdMascota" class="form-select" required><option value="">Seleccionar mascota...</option>
          <?php foreach ($mascotas as $mascota): ?><option value="<?= (int)$mascota["Id"] ?>"><?= htmlspecialchars($mascota["Nombre"] . " - " . $mascota["NombreUsuario"] . " " . $mascota["ApellidoUsuario"]) ?></option><?php endforeach; ?>
        </select>
      </section>
      <section class="col-6 mb-3">
        <label for="Fecha" class="form-label">Fecha</label>
      <input name="Fecha" type="date" class="form-control" id="Fecha" min="<?= date("Y-m-d") ?>" required></section>
      <section class="col-6 mb-3">
        <label for="Hora" class="form-label">Hora</label>
        <input name="Hora" type="time" class="form-control" id="Hora" required></section>
      <section class="col-12 mb-3"><label for="Motivo" class="form-label">Motivo</label><textarea name="Motivo" id="Motivo" class="form-control" maxlength="500" required></textarea></section>
      <section class="col-12 mb-3"><input class="btn btn-secondary" type="reset" value="Resetear valores"></section>
      <section class="col-12"><input name="boton" class="btn btn-success mb-3" type="submit" value="Agregar cita"></section>
      <section class="col-6 mb-6"><a href="./ListarCita.php" class="btn btn-danger">Salir</a></section>
    </main>
  </form>
</div>
<div class="toast-container position-fixed bottom-0 end-0 p-3"><div id="liveToast" class="toast" data-mostrar="<?= $mensajeToast !== "" ? "true" : "false" ?>"><div class="toast-header"><strong class="me-auto">Veterinaria</strong></div><div class="toast-body bg-success text-white"><?= htmlspecialchars($mensajeToast, ENT_QUOTES, "UTF-8") ?></div></div></div>
<script src="../../JavaScript/Interfaz.js"></script>
</body>
</html>
