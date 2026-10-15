<?php
require_once "../../php/config.php";
require_once "../../php/Cita.php";
VerificarAdministrador();
$cita = new Cita();
$id = filter_var(
    $_GET["IdCita"] ?? $_POST["IdCita"] ?? null, FILTER_VALIDATE_INT
);

if ($id === false || $id === null || !($datos = (new Cita($id))->ConsultarCita())) {
    header("Location: ListarCita.php");
    exit();
}

$mensaje = $_SESSION["Mensaje"] ?? "";
unset($_SESSION["Mensaje"]);

if (isset($_POST["boton"])) {
    $fecha = $_POST["Fecha"] ?? "";
    $hora = $_POST["Hora"] ?? "";
    $estado = trim($_POST["Estado"] ?? "");
    $motivo = trim($_POST["Motivo"] ?? "");
    $activo = ($_POST["Activo"] ?? "0") === "1";

    if ($fecha === "" || $hora === "" || $estado === "" || $motivo === "") {
        $_SESSION["Mensaje"] = "Completá todos los campos.";
    } elseif ($fecha < date("Y-m-d")) {
        $_SESSION["Mensaje"] = "La fecha de la cita no puede ser anterior a hoy.";
    } else {
        $fechaCita = DateTime::createFromFormat("Y-m-d", $fecha);
        $cita = new Cita($id, $fechaCita ?: null, $estado, $motivo, $activo);

        if ($fechaCita !== false && $cita->ModificarCita()) {
            $_SESSION["MensajeToast"] = "Cita modificada correctamente.";
            header("Location: ListarCita.php");
            exit();
        }

        $_SESSION["Mensaje"] = "No se pudo modificar la cita.";
    }

    header("Location: " . $_SERVER["PHP_SELF"] . "?IdCita=" . $id);
    exit();
}

if (isset($_POST["botonClose"])) {
    CerrarSesion();
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/interfaz.css">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <title>Modificar cita</title>
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
                    <button
                        class="btn btn-secondary dropdown-toggle"
                        type="button"
                        data-bs-toggle="dropdown"
                    >
                        Opciones
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <form method="post">
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

        <section class="row">
            <div class="col-12 d-flex justify-content-center align-items-center">
                <h2>Citas</h2>
            </div>
        </section>

        <div class="row">
            <section class="col-12 col-md-4 offset-md-4 text-center">
                <h2>Modificar cita</h2>
            </section>
            <div class="col-12 col-md-3 text-md-end">
                <a class="btn btn-success" href="./AltaCita.php">Agregar Cita</a>
            </div>
        </div>
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

        <form method="post" class="overflow-auto flex-grow-1">
            <main class="row align-content-start">
                <input type="hidden" name="IdCita" value="<?= (int) $id ?>">

                <?php if ($mensaje !== ""): ?>
                    <div class="col-12 text-danger text-center mb-3">
                        <?= htmlspecialchars($mensaje, ENT_QUOTES, "UTF-8") ?>
                    </div>
                <?php endif; ?>

                <section class="col-6 mb-3">
                    <label for="Fecha" class="form-label">Fecha</label>
                    <input
                        name="Fecha"
                        value="<?= htmlspecialchars($datos["Fecha"]) ?>"
                        type="date"
                        class="form-control"
                        id="Fecha"
                        required
                    >
                </section>

                <section class="col-6 mb-3">
                    <label for="Hora" class="form-label">Hora</label>
                    <input
                        name="Hora"
                        value="<?= htmlspecialchars(substr($datos["Hora"], 0, 5)) ?>"
                        type="time"
                        class="form-control"
                        id="Hora"
                        required
                    >
                </section>

                <section class="col-6 mb-3">
                    <label for="Estado" class="form-label">Estado</label>
                    <select name="Estado" id="Estado" class="form-select" required>
                        <?php foreach (["Pendiente", "Confirmada", "Cancelada", "Finalizada"] as $estado): ?>
                            <option
                                value="<?= $estado ?>"
                                <?= $datos["Estado"] === $estado ? "selected" : "" ?>
                            >
                                <?= $estado ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </section>

                <section class="col-6 mb-3">
                    <label for="Activo" class="form-label">Activo</label>
                    <select name="Activo" id="Activo" class="form-select">
                        <option value="1" <?= $datos["Activo"] ? "selected" : "" ?>>Sí</option>
                        <option value="0" <?= !$datos["Activo"] ? "selected" : "" ?>>No</option>
                    </select>
                </section>

                <section class="col-12 mb-3">
                    <label for="Motivo" class="form-label">Motivo</label>
                    <textarea
                        name="Motivo"
                        id="Motivo"
                        class="form-control"
                        maxlength="500"
                        required
                    ><?= htmlspecialchars($datos["Motivo"]) ?></textarea>
                </section>

                <section class="col-12">
                    <input
                        name="boton"
                        class="btn btn-success mb-3"
                        type="submit"
                        value="Aceptar cambios"
                    >
                </section>

                <section class="col-12 mb-3">
                    <input class="btn btn-secondary" type="reset" value="Restablecer valores">
                </section>

                <section class="col-12 mb-3">
                    <a href="./ListarCita.php" class="btn btn-danger">Salir</a>
                </section>
            </main>
        </form>
    </div>
</body>
</html>
