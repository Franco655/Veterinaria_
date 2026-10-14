<?php
require_once "../php/config.php";
require_once "../php/Usuario.php";
require_once "../php/Login.php";

if (!isset($_SESSION["Nombre"], $_SESSION["Rol"])) {
    header("Location: ./InicioSesion.php");
    exit();
}

$login = new Login($_SESSION["Nombre"]);
$datosUsuario = $login->ConsultarUsuario();

if (!is_array($datosUsuario)) {
    header("Location: ./InicioSesion.php");
    exit();
}

$errores = [];
$tipoMensaje = "danger";

if (isset($_POST["guardar"])) {
    $nombre = trim($_POST["Nombre"] ?? "");
    $apellido = trim($_POST["Apellido"] ?? "");
    $mail = trim($_POST["Mail"] ?? "");
    $direccion = trim($_POST["Direccion"] ?? "");
    $telefono = trim($_POST["Telefono"] ?? "");
    $nombreDeUsuario = trim($_POST["NombreDeUsuario"] ?? "");

    if ($nombre === "") {
        $errores[] = "El nombre es obligatorio.";
    }
    if ($apellido === "") {
        $errores[] = "El apellido es obligatorio.";
    }
    if ($mail === "") {
        $errores[] = "El correo electrónico es obligatorio.";
    } elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "Ingresá un correo electrónico válido.";
    }
    if ($direccion === "") {
        $errores[] = "La dirección es obligatoria.";
    }
    if ($telefono === "") {
        $errores[] = "El teléfono es obligatorio.";
    } elseif (!ctype_digit($telefono)) {
        $errores[] = "El teléfono debe contener solamente números.";
    }
    if ($nombreDeUsuario === "") {
        $errores[] = "El nombre de usuario es obligatorio.";
    }

    if (count($errores) === 0) {
        $usuario = new Usuario(
            $datosUsuario["Ci"],
            $nombre,
            $apellido,
            $mail,
            $direccion,
            (int) $telefono,
            $datosUsuario["Rol"]
        );
        $loginNuevo = new Login($nombreDeUsuario);

        $mensajeCi = $usuario->VerificarMail($datosUsuario["Ci"]);
        $mensajeUsuario = $loginNuevo->VerificarUsuario($datosUsuario["NombreDeUsuario"]);

        if ($mensajeCi !== "") {
            $errores[] = $mensajeCi;
        }
        if ($mensajeUsuario !== "") {
            $errores[] = $mensajeUsuario;
        }

        if (count($errores) === 0) {
            $usuario->ModificarPerfil($datosUsuario["Ci"]);
            $loginNuevo->ModificarLogin($datosUsuario["Ci"]);

            $_SESSION["Nombre"] = $nombreDeUsuario;
            $datosActualizados = $loginNuevo->ConsultarUsuario();
            if (is_array($datosActualizados)) {
                $_SESSION["Usuario"] = $datosActualizados;
            }

            header("Location: ./Perfil.php");
            exit();
        }
    }

    $datosUsuario["Nombre"] = $nombre;
    $datosUsuario["Apellido"] = $apellido;
    $datosUsuario["Mail"] = $mail;
    $datosUsuario["Direccion"] = $direccion;
    $datosUsuario["Telefono"] = $telefono;
    $datosUsuario["NombreDeUsuario"] = $nombreDeUsuario;
}

$escapar = static function ($valor): string {
    return htmlspecialchars((string) ($valor ?? ""), ENT_QUOTES, "UTF-8");
};
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modificar perfil | Veterinaria Maldonado</title>
  <link rel="icon" type="image/png" href="../archivos.img/LogoTransparente.png">
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
    crossorigin="anonymous">
  <link rel="stylesheet" href="../css/PanelDeUsuario.css">
</head>
<body>
  <!-- Encabezado compartido con el panel de usuario. -->
  <header class="PanelHeader">
    <nav class="navbar" aria-label="Encabezado del panel de usuario">
      <div class="container PanelHeaderContent">
        <div class="PanelHeaderBrand">
          <img
            class="PanelHeaderLogo"
            src="../archivos.img/LogoVeterinaria2-removebg-preview.png"
            alt="Logo de Veterinaria Maldonado">
        </div>

        <div class="PanelHeaderActions">
          <a class="btn PanelHeaderButton" href="./Perfil.php">Perfil</a>
          <a class="btn PanelHeaderButton" href="./index.php">Inicio</a>
          <a class="btn PanelHeaderButton" href="./InicioSesion.php">Cerrar sesión</a>
        </div>
      </div>
    </nav>
  </header>

  <main class="container PerfilContainer">
    <div class="PerfilIntro">
      <p class="text-uppercase text-success fw-semibold mb-1">Mi espacio</p>
      <h1 class="display-6 fw-bold mb-2">Modificar perfil</h1>
      <p class="text-muted mb-0">Actualizá tus datos personales y de contacto.</p>
    </div>

    <?php if (count($errores) > 0): ?>
      <div class="alert alert-<?= $tipoMensaje ?>" role="alert">
        <ul class="mb-0">
          <?php foreach ($errores as $error): ?>
            <li><?= $escapar($error) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form method="post" class="row g-3">
      <div class="col-md-6">
        <label for="Nombre" class="form-label">Nombre</label>
        <input id="Nombre" name="Nombre" class="form-control" value="<?= $escapar($datosUsuario["Nombre"]) ?>" required>
      </div>
      <div class="col-md-6">
        <label for="Apellido" class="form-label">Apellido</label>
        <input id="Apellido" name="Apellido" class="form-control" value="<?= $escapar($datosUsuario["Apellido"]) ?>" required>
      </div>
      <div class="col-md-6">
        <label for="NombreDeUsuario" class="form-label">Nombre de usuario</label>
        <input id="NombreDeUsuario" name="NombreDeUsuario" class="form-control" value="<?= $escapar($datosUsuario["NombreDeUsuario"]) ?>" required>
      </div>
      <div class="col-md-6">
        <label for="Mail" class="form-label">Correo electrónico</label>
        <input id="Mail" name="Mail" type="email" class="form-control" value="<?= $escapar($datosUsuario["Mail"]) ?>" required>
      </div>
      <div class="col-md-6">
        <label for="Telefono" class="form-label">Teléfono</label>
        <input id="Telefono" name="Telefono" type="tel" inputmode="numeric" class="form-control" value="<?= $escapar($datosUsuario["Telefono"]) ?>" required>
      </div>
      <div class="col-md-6">
        <label for="Direccion" class="form-label">Dirección</label>
        <input id="Direccion" name="Direccion" class="form-control" value="<?= $escapar($datosUsuario["Direccion"]) ?>" required>
      </div>
      <div class="col-12 d-flex gap-2">
        <button type="submit" name="guardar" class="btn PerfilEditButton">Guardar cambios</button>
        <a href="./Perfil.php" class="btn PerfilEditButton">Cancelar</a>
      </div>
    </form>
  </main>
</body>
</html>
