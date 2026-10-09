<?php
require_once "../../php/config.php";
require_once "../../php/Proveedor.php";

VerificarSesion();

if (isset($_POST['boton'])) {
    $nombre = trim($_POST['Nombre'] ?? '');
    $telefono = trim($_POST['Telefono'] ?? '');

    if ($nombre !== '' && $telefono !== '') {
        $proveedor = new Proovedor(null, $nombre, $telefono);
        $_SESSION['MensajeToast'] = $proveedor->AltaProveedor()
            ? 'Proveedor agregado correctamente'
            : 'No se pudo agregar el proveedor';
    } else {
        $_SESSION['MensajeToast'] = 'Completa el nombre y el teléfono';
    }

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_POST['botonClose'])) {
    CerrarSesion();
    header('Location: ../index.php');
    exit();
}

$MensajeToast = $_SESSION['MensajeToast'] ?? '';
unset($_SESSION['MensajeToast']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/interfaz.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <title>Agregar proveedor</title>
    <link rel="icon" type="image/png" href="../../archivos.img/LogoTransparente.png">
</head>
<body class="d-flex flex-column vh-100" style="background-color: #282626; color: #ffffff;">

<header class="mx-0 flex-shrink-0">
    <div class="row">
        <section class="col-12 col-md-4">
            <h2><?= htmlspecialchars($_SESSION["Nombre"], ENT_QUOTES, 'UTF-8') ?></h2>
            <p><?= htmlspecialchars($_SESSION["Rol"], ENT_QUOTES, 'UTF-8') ?></p>
        </section>

        <div class="offset-md-4 col-12 col-md-4 d-flex justify-content-md-end align-items-center">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    Opciones
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li>
                        <form method="post" action="">
                            <button name="botonClose" class="dropdown-item" type="submit">Cerrar sesión</button>
                        </form>
                    </li>
                    <li><a class="dropdown-item" href="../index.php">Menu principal</a></li>
                </ul>
            </div>
        </div>
    </div>

    <section class="row">
        <div class="col-12 d-flex justify-content-center align-items-center">
            <h2>Proveedores</h2>
        </div>
    </section>

    <div class="row">
        <section class="col-12 col-md-4 offset-md-4 text-center">
            <h2>Agregar Proveedor</h2>
        </section>
    </div>
</header>

<hr class="m-0">

<div class="d-flex vh-100">
    <div>
        <ul class="nav flex-column h-100">
            <li class="nav-item"><a class="nav-link" href="#">Citas</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Ventas</a></li>
            <li class="nav-item"><a class="nav-link" href="../Socio/ListarSocio.php">Membresías</a></li>
            <li class="nav-item"><a class="nav-link" href="../Mascota/ListarMascota.php">Mascotas</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Alertas</a></li>
            <li class="nav-item"><a class="nav-link" href="../Producto/ListarProducto.php">Productos</a></li>
            <li class="nav-item"><a class="nav-link" href="./ListaProveedor.php">Proveedores</a></li>
            <?php if ($_SESSION["Rol"] === "Administrador") { ?>
                <li class="nav-item"><a class="nav-link" href="../Usuario/ListarUsuario.php">Usuarios</a></li>
            <?php } ?>
        </ul>
    </div>

    <div class="vr"></div>

    <form method="post" class="overflow-auto" action="">
        <main class="row flex-grow-1 h-100 align-content-start">
            <section class="col-6 mb-3">
                <label for="Nombre" class="form-label">Nombre</label>
                <input name="Nombre" type="text" maxlength="75" class="form-control" id="Nombre" required>
            </section>

            <section class="col-12 col-md-6 mb-3">
                <label for="Telefono" class="form-label">Teléfono</label>
                <input name="Telefono" type="tel" maxlength="25" class="form-control" id="Telefono" required>
            </section>

            <section class="col-12 mb-3">
                <input class="btn btn-secondary mb-3" type="reset" value="Resetear valores">
            </section>

            <section class="col-12 mb-3">
                <button name="boton" class="btn btn-success mb-3" type="submit">Agregar proveedor</button>
            </section>

            <section class="col-6 mb-3">
                <a href="./ListaProveedor.php" class="btn btn-danger" role="button">Salir</a>
            </section>
        </main>
    </form>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="liveToast" class="toast" data-mostrar="<?= $MensajeToast !== '' ? 'true' : 'false' ?>" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Veterinaria</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body bg-success text-white">
            <?= htmlspecialchars($MensajeToast, ENT_QUOTES, 'UTF-8') ?>
        </div>
    </div>
</div>

<script src="../../JavaScript/Interfaz.js"></script>
</body>
</html>
