<?php
require_once "../../php/config.php";
require_once "../../php/Proveedor.php";

VerificarSesion();

if (!isset($_SESSION["Proveedor"]) || !is_array($_SESSION["Proveedor"])) {
    header("Location: ./ListaProveedor.php");
    exit();
}

$proveedor = $_SESSION["Proveedor"];
$error = "";
$nombre = $proveedor["Nombre"] ?? "";
$telefono = $proveedor["Telefono"] ?? "";

if (isset($_POST["boton"])) {
    $nombre = trim($_POST["Nombre"] ?? "");
    $telefono = trim($_POST["Telefono"] ?? "");
    $idProveedor = (int)($proveedor["Id"] ?? 0);

    if ($idProveedor > 0 && $nombre !== "" && $telefono !== "") {
        $proveedorModel = new Proovedor($idProveedor, $nombre, $telefono);
        if ($proveedorModel->ModificarProveedor()) {
            unset($_SESSION["Proveedor"]);
            header("Location: ./ListaProveedor.php");
            exit();
        }
        $error = "No se pudo actualizar el proveedor.";
    } else {
        $error = "Completa el nombre y el teléfono.";
    }
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <title>Modificar proveedor</title>
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
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">Opciones</button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li>
                        <form method="post" action="">
                            <button name="botonClose" class="dropdown-item" type="submit">Cerrar sesión</button>
                        </form>
                    </li>
                    <li><a class="dropdown-item" href="../index.php">Menú principal</a></li>
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
            <h2>Modificar proveedor</h2>
        </section>
    </div>
</header>
<hr class="m-0">
<div class="d-flex vh-100">
    <nav>
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
    </nav>
    <div class="vr"></div>
    <form method="post" class="overflow-auto" action="">
        <main class="row align-content-start">
            <section class="col-12 col-md-6 mb-3">
                <label for="Nombre" class="form-label">Nombre</label>
                <input name="Nombre" value="<?= htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') ?>" type="text" maxlength="75" class="form-control" id="Nombre" required>
            </section>
            <section class="col-12 col-md-6 mb-3">
                <label for="Telefono" class="form-label">Teléfono</label>
                <input name="Telefono" value="<?= htmlspecialchars($telefono, ENT_QUOTES, 'UTF-8') ?>" type="tel" maxlength="25" class="form-control" id="Telefono" required>
            </section>
            <?php if ($error !== "") { ?>
                <div class="col-12 mb-3 alert alert-danger" role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
            <?php } ?>
            <section class="col-12 mb-3">
                <button name="boton" class="btn btn-success" type="submit">Guardar cambios</button>
            </section>
            <section class="col-12 mb-3">
                <a href="./ListaProveedor.php" class="btn btn-danger" role="button">Cancelar</a>
            </section>
        </main>
    </form>
</div>
</body>
</html>
