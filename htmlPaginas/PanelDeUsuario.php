<?php
require_once "../php/config.php";
require_once "../php/Usuario.php";
require_once "../php/Login.php";
require_once "../php/Mascota.php";
require_once "../php/Cita.php";

if (!isset($_SESSION["Nombre"], $_SESSION["Rol"])) {
  header("Location: ./InicioSesion.php");
  exit();
}

$usuarioLogin = new Login($_SESSION["Nombre"]);
$datosUsuario = $usuarioLogin->ConsultarUsuario();

if (!is_array($datosUsuario)) {
  header("Location: ./InicioSesion.php");
  exit();
}

$ciUsuario = (string) $datosUsuario["Ci"];
$_SESSION["Ci"] = $ciUsuario;

$mensajePanel = $_SESSION["MensajePanel"] ?? "";
$tipoMensajePanel = $_SESSION["TipoMensajePanel"] ?? "success";
unset($_SESSION["MensajePanel"], $_SESSION["TipoMensajePanel"]);

$mascota = new Mascota();

if (isset($_POST["eliminar_mascota"])) {
  $idMascota = filter_var($_POST["IdMascotaEliminar"] ?? null, FILTER_VALIDATE_INT);

  if ($idMascota !== false && $idMascota !== null) {
    $mascotaEliminar = new Mascota($idMascota);
    if ($mascotaEliminar->EliminarMascotaUsuario($ciUsuario)) {
      $_SESSION["MensajePanel"] = "Mascota eliminada correctamente.";
    } else {
      $_SESSION["MensajePanel"] = "No se pudo eliminar la mascota.";
      $_SESSION["TipoMensajePanel"] = "danger";
    }
  }

  header("Location: " . $_SERVER["PHP_SELF"]);
  exit();
}

if (isset($_POST["agregar_mascota"])) {
  $nombre = trim($_POST["NombreMascota"] ?? "");
  $raza = trim($_POST["RazaMascota"] ?? "");
  $nacimiento = $_POST["NacimientoMascota"] ?? "";
  $peso = trim($_POST["PesoMascota"] ?? "");
  $castrado = isset($_POST["CastradoMascota"]) ? 1 : 0;

  if ($nombre === "" || $raza === "" || $nacimiento === "" || $peso === "") {
    $mensajePanel = "Completá todos los campos de la mascota.";
    $tipoMensajePanel = "danger";
  } elseif (!is_numeric($peso) || (float) $peso < 0) {
    $mensajePanel = "El peso debe ser un número válido.";
    $tipoMensajePanel = "danger";
  } else {
    $nuevaMascota = new Mascota(
      null,
      $raza,
      $nombre,
      new DateTime($nacimiento),
      (bool) $castrado,
      (float) $peso
    );
    $nuevaMascota->AltaMascota($ciUsuario);
    $_SESSION["MensajePanel"] = "Mascota agregada correctamente.";
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
  }
}

$mascotas = $mascota->ListarMascotasPorCI($ciUsuario);

if (isset($_POST["agregar_cita"])) {
  $idMascota = filter_var($_POST["IdMascota"] ?? null, FILTER_VALIDATE_INT);
  $fecha = $_POST["FechaCita"] ?? "";
  $hora = $_POST["HoraCita"] ?? "";
  $motivo = trim($_POST["MotivoCita"] ?? "");

  if ($idMascota === false || $idMascota === null || $fecha === "" || $hora === "" || $motivo === "") {
    $mensajePanel = "Completá todos los campos de la cita.";
    $tipoMensajePanel = "danger";
  } elseif ($fecha < date("Y-m-d")) {
    $mensajePanel = "La fecha de la cita no puede ser anterior a hoy.";
    $tipoMensajePanel = "danger";
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
      $_SESSION["MensajePanel"] = "Cita solicitada correctamente.";
      header("Location: " . $_SERVER["PHP_SELF"]);
      exit();
    }

    $mensajePanel = "No se pudo crear la cita. Verificá que la mascota te pertenezca.";
    $tipoMensajePanel = "danger";
  }
}

$cita = new Cita();

if (isset($_POST["eliminar_cita"])) {
  $idCita = filter_var($_POST["IdCitaEliminar"] ?? null, FILTER_VALIDATE_INT);

  if ($idCita !== false && $idCita !== null) {
    $citaEliminar = new Cita($idCita);
    if ($citaEliminar->EliminarCita($ciUsuario)) {
      $_SESSION["MensajePanel"] = "Cita eliminada correctamente.";
    } else {
      $_SESSION["MensajePanel"] = "No se pudo eliminar la cita.";
      $_SESSION["TipoMensajePanel"] = "danger";
    }
  }

  header("Location: " . $_SERVER["PHP_SELF"]);
  exit();
}

$citas = $cita->ListarProximasPorCi($ciUsuario);
$vacunas = [];

$escapar = static function ($valor): string {
  return htmlspecialchars((string) ($valor ?? ""), ENT_QUOTES, "UTF-8");
};


if (isset($_POST['boton'])) {
  $Login = new Login($_POST['Nombre']);
 $Usuario=$Login->consultarUsuario();
$_SESSION['Usuario'] = $Usuario;
  header("Location: ./Perfil.php");
  exit();
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel de usuario | Veterinaria Maldonado</title>
  <link rel="icon" type="image/png" href="../archivos.img/LogoTransparente.png">

  <!-- Bootstrap se utiliza solamente para la grilla y las clases responsive. -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
    crossorigin="anonymous">
  <link rel="stylesheet" href="../css/PanelDeUsuario.css">
</head>
<body>
  <!-- Encabezado visual del panel. Los datos mostrados son de ejemplo. -->
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
          <form action="PanelDeUsuario.php" method="post" class="d-inline">
            <input type="hidden" name="Nombre" value="<?= htmlspecialchars($_SESSION["Nombre"], ENT_QUOTES, 'UTF-8') ?>">
            <button name="boton" class="btn PanelHeaderButton" type="submit">Perfil</button>
          </form>
          <a class="btn PanelHeaderButton" href="./index.php">Inicio</a>
          <a class="btn PanelHeaderButton" href="./InicioSesion.php">Cerrar sesión</a>
        </div>
      </div>
    </nav>
  </header>

  <main class="container py-4">
    <?php if ($mensajePanel !== ""): ?>
      <div class="alert alert-<?= $escapar($tipoMensajePanel) ?>" role="alert">
        <?= $escapar($mensajePanel) ?>
      </div>
    <?php endif; ?>

    <div class="mb-4">
      <p class="text-uppercase text-success fw-semibold mb-1">Mi espacio, <?= htmlspecialchars($_SESSION["Nombre"], ENT_QUOTES, 'UTF-8') ?></p>
      <h1 class="display-6 fw-bold mb-2">Panel de usuario</h1>
      <p class="text-muted mb-0">
        Consultá la información importante de tus mascotas.
      </p>
    </div>

    <div class="row g-4">
      <!-- Primer panel: mascotas pertenecientes al usuario autenticado. -->
      <div class="col-12 col-xl-4">
        <section class="DashboardCard h-100">
          <div class="DashboardCardHeading">
            <span class="DashboardIcon DashboardIconPets">🐾</span>
            <div>
              <h2 class="h4 mb-1">Mis mascotas</h2>
              <p class="text-muted mb-0">Tus compañeros registrados</p>
            </div>
            <button type="button" class="btn btn-sm btn-success ms-auto" data-bs-toggle="modal" data-bs-target="#modalMascota">
              Agregar
            </button>
          </div>

          <div class="list-group list-group-flush">
            <?php if (count($mascotas) === 0): ?>
              <p class="EmptyState">No tenés mascotas registradas.</p>
            <?php else: ?>
              <?php foreach ($mascotas as $mascota): ?>
                <article class="DashboardListItem">
                  <div>
                    <h3 class="h5 mb-1"><?= $escapar($mascota["Nombre"]) ?></h3>
                    <p class="mb-1 text-muted"><?= $escapar($mascota["Raza"]) ?></p>
                    <small class="text-muted">
                      Nacimiento: <?= $escapar(date("d/m/Y", strtotime($mascota["FechaNacimiento"]))) ?>
                    </small>
                  </div>
                  <span class="badge rounded-pill text-bg-<?= !empty($mascota["Castrado"]) ? "success" : "secondary" ?>">
                    <?= !empty($mascota["Castrado"]) ? "Castrado" : "Sin castrar" ?>
                  </span>
                  <button type="button"
                          class="btn btn-sm btn-outline-danger"
                          data-bs-toggle="modal"
                          data-bs-target="#modalEliminarMascota<?= $escapar($mascota["Id"]) ?>">
                    Eliminar
                  </button>
                </article>
                <div class="modal fade" id="modalEliminarMascota<?= $escapar($mascota["Id"]) ?>" tabindex="-1" aria-labelledby="modalEliminarMascotaLabel<?= $escapar($mascota["Id"]) ?>" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <form method="post">
                        <div class="modal-header">
                          <h2 class="modal-title fs-5" id="modalEliminarMascotaLabel<?= $escapar($mascota["Id"]) ?>">Eliminar mascota</h2>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                          ¿Seguro que querés eliminar a <strong><?= $escapar($mascota["Nombre"]) ?></strong>?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                          <input type="hidden" name="IdMascotaEliminar" value="<?= $escapar($mascota["Id"]) ?>">
                          <button type="submit" name="eliminar_mascota" class="btn btn-danger">Eliminar</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </section>
      </div>

      <!-- Segundo panel: próximas citas del usuario autenticado. -->
      <div class="col-12 col-xl-4">
        <section class="DashboardCard h-100">
          <div class="DashboardCardHeading">
            <span class="DashboardIcon DashboardIconAppointments">📅</span>
            <div>
              <h2 class="h4 mb-1">Próximas citas</h2>
              <p class="text-muted mb-0">No te olvides de ninguna visita</p>
            </div>
            <button type="button" class="btn btn-sm btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#modalCita">
              Agregar
            </button>
          </div>

          <div class="list-group list-group-flush">
            <?php if (count($citas) === 0): ?>
              <p class="EmptyState">No tenés próximas citas.</p>
            <?php else: ?>
              <?php foreach ($citas as $cita): ?>
                <article class="DashboardListItem">
                  <div>
                    <h3 class="h5 mb-1"><?= $escapar(date("d/m/Y", strtotime($cita["Fecha"]))) ?></h3>
                    <p class="mb-1"><?= $escapar($cita["NombreMascota"]) ?> <span class="text-muted">· <?= $escapar(substr($cita["Hora"], 0, 5)) ?> h</span></p>
                    <small class="text-muted"><?= $escapar($cita["Motivo"]) ?></small>
                  </div>
                  <span class="badge rounded-pill text-bg-primary"><?= $escapar($cita["Estado"]) ?></span>
                  <button type="button"
                          class="btn btn-sm btn-outline-danger"
                          data-bs-toggle="modal"
                          data-bs-target="#modalEliminarCita<?= $escapar($cita["IdCita"]) ?>">
                    Eliminar
                  </button>
                </article>
                <div class="modal fade" id="modalEliminarCita<?= $escapar($cita["IdCita"]) ?>" tabindex="-1" aria-labelledby="modalEliminarCitaLabel<?= $escapar($cita["IdCita"]) ?>" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <form method="post">
                        <div class="modal-header">
                          <h2 class="modal-title fs-5" id="modalEliminarCitaLabel<?= $escapar($cita["IdCita"]) ?>">Eliminar cita</h2>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                          ¿Seguro que querés eliminar la cita de <strong><?= $escapar($cita["NombreMascota"]) ?></strong> del <?= $escapar(date("d/m/Y", strtotime($cita["Fecha"]))) ?>?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                          <input type="hidden" name="IdCitaEliminar" value="<?= $escapar($cita["IdCita"]) ?>">
                          <button type="submit" name="eliminar_cita" class="btn btn-danger">Eliminar</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </section>
      </div>

      <!-- Tercer panel: vacunas del usuario próximas a vencer. -->
      <div class="col-12 col-xl-4">
        <section class="DashboardCard h-100">
          <div class="DashboardCardHeading">
            <span class="DashboardIcon DashboardIconVaccines">💉</span>
            <div>
              <h2 class="h4 mb-1">Vacunas por vencer</h2>
              <p class="text-muted mb-0">Próximos 30 días</p>
            </div>
          </div>

          <div class="list-group list-group-flush">
            <?php if (count($vacunas) === 0): ?>
              <p class="EmptyState">No hay vacunas por vencer en los próximos 30 días.</p>
            <?php else: ?>
              <?php foreach ($vacunas as $vacuna): ?>
                <article class="DashboardListItem">
                  <div>
                    <h3 class="h5 mb-1"><?= $escapar($vacuna["Nombre"]) ?></h3>
                    <p class="mb-0 text-muted"><?= $escapar($vacuna["NombreMascota"]) ?></p>
                  </div>
                  <span class="badge rounded-pill text-bg-warning"><?= $escapar(date("d/m/Y", strtotime($vacuna["FechaDeVencimiento"]))) ?></span>
                </article>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </section>
      </div>
    </div>
  </main>

  <div class="modal fade" id="modalMascota" tabindex="-1" aria-labelledby="modalMascotaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form method="post">
          <div class="modal-header">
            <h2 class="modal-title fs-5" id="modalMascotaLabel">Agregar mascota</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="NombreMascota" class="form-label">Nombre</label>
              <input type="text" class="form-control" id="NombreMascota" name="NombreMascota" required>
            </div>
            <div class="mb-3">
              <label for="RazaMascota" class="form-label">Raza</label>
              <input type="text" class="form-control" id="RazaMascota" name="RazaMascota" required>
            </div>
            <div class="mb-3">
              <label for="NacimientoMascota" class="form-label">Fecha de nacimiento</label>
              <input type="date" class="form-control" id="NacimientoMascota" name="NacimientoMascota" required>
            </div>
            <div class="mb-3">
              <label for="PesoMascota" class="form-label">Peso</label>
              <input type="number" class="form-control" id="PesoMascota" name="PesoMascota" min="0" step="0.01" required>
            </div>
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="CastradoMascota" name="CastradoMascota">
              <label class="form-check-label" for="CastradoMascota">Castrado</label>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" name="agregar_mascota" class="btn btn-success">Guardar mascota</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalCita" tabindex="-1" aria-labelledby="modalCitaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form method="post">
          <div class="modal-header">
            <h2 class="modal-title fs-5" id="modalCitaLabel">Agregar cita</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <?php if (count($mascotas) === 0): ?>
              <p class="text-muted mb-0">Primero tenés que registrar una mascota.</p>
            <?php else: ?>
              <div class="mb-3">
                <label for="IdMascota" class="form-label">Mascota</label>
                <select class="form-select" id="IdMascota" name="IdMascota" required>
                  <option value="">Seleccioná una mascota</option>
                  <?php foreach ($mascotas as $mascota): ?>
                    <option value="<?= $escapar($mascota["Id"]) ?>"><?= $escapar($mascota["Nombre"]) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="mb-3">
                <label for="FechaCita" class="form-label">Fecha</label>
                <input type="date" class="form-control" id="FechaCita" name="FechaCita" min="<?= date("Y-m-d") ?>" required>
              </div>
              <div class="mb-3">
                <label for="HoraCita" class="form-label">Hora</label>
                <input type="time" class="form-control" id="HoraCita" name="HoraCita" required>
              </div>
              <div class="mb-3">
                <label for="MotivoCita" class="form-label">Motivo</label>
                <textarea class="form-control" id="MotivoCita" name="MotivoCita" rows="3" required></textarea>
              </div>
            <?php endif; ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <?php if (count($mascotas) > 0): ?>
              <button type="submit" name="agregar_cita" class="btn btn-primary">Guardar cita</button>
            <?php endif; ?>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
</body>
</html>
