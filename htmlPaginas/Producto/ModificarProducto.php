<?php
require_once "../../php/config.php";
require_once "../../php/Producto.php";
require_once "../../php/Proveedor.php";

VerificarSesion();

if (!isset($_SESSION['Producto'])) {
    header('Location: ./ListarProducto.php');
    exit();
}

$proveedorModel = new Proovedor();
$proveedores = $proveedorModel->ListarProveedor();

if (isset($_POST['boton'])) {
    $id = (int)($_SESSION['Producto']['Id'] ?? 0);
    $nombre = trim($_POST['Nombre'] ?? '');
    $descripcion = trim($_POST['Descripcion'] ?? '');
    $precio = (float)($_POST['Precio'] ?? 0);
    $stock = (int)($_POST['Stock'] ?? 0);
    $tipo = trim($_POST['Tipo'] ?? '');
    $marca = trim($_POST['Marca'] ?? '');
    $fechaVencimiento = $_POST['FechaVencimiento'] ?? null;
    $idProveedor = (int)($_POST['IdProveedor'] ?? 0);

    if ($id > 0 && $nombre !== '' && $precio > 0 && $stock >= 0 && $idProveedor > 0) {
        $producto = new Producto(
            $id,
            $nombre,
            $descripcion,
            $precio,
            $stock,
            $tipo,
            $marca,
            $fechaVencimiento ? new DateTime($fechaVencimiento) : null
        );

        $producto->ModificarProducto();
        unset($_SESSION['Producto']);
        header('Location: ./ListarProducto.php');
        exit();
    }

    $_SESSION['MensajeToast'] = 'No se pudo actualizar el producto';
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_POST['botonClose'])) {
    CerrarSesion();
    header('Location: ../index.php');
    exit();
}

$producto = $_SESSION['Producto'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/interfaz.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <title>Modificar producto</title>
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
            <h2>Productos</h2>
        </div>
    </section>

    <div class="row">
        <section class="col-12 col-md-4 offset-md-4 text-center">
            <h2>Modificar Producto</h2>
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
            <li class="nav-item"><a class="nav-link" href="./ListarProducto.php">Productos</a></li>
            <li class="nav-item"><a class="nav-link" href="../Proveedor/ListaProveedor.php">Proveedores</a></li>
            <?php if ($_SESSION["Rol"] === "Administrador") { ?>
                <li class="nav-item"><a class="nav-link" href="../Usuario/ListarUsuario.php">Usuarios</a></li>
            <?php } ?>
        </ul>
    </div>

    <div class="vr"></div>

    <form method="post" class="overflow-auto" action="">
        <main class="row align-content-start">
            <section class="col-6 mb-3">
                <label for="Nombre" class="form-label">Nombre</label>
                <input name="Nombre" value="<?= htmlspecialchars($producto['Nombre'] ?? '', ENT_QUOTES, 'UTF-8') ?>" type="text" class="form-control" id="Nombre" required>
            </section>

            <section class="col-6 mb-3">
                <label for="Descripcion" class="form-label">Descripción</label>
                <input name="Descripcion" value="<?= htmlspecialchars($producto['Descripcion'] ?? '', ENT_QUOTES, 'UTF-8') ?>" type="text" class="form-control" id="Descripcion">
            </section>

            <section class="col-6 mb-3">
                <label for="Precio" class="form-label">Precio</label>
                <input name="Precio" value="<?= htmlspecialchars($producto['Precio'] ?? '', ENT_QUOTES, 'UTF-8') ?>" type="number" step="0.01" min="0" class="form-control" id="Precio" required>
            </section>

            <section class="col-6 mb-3">
                <label for="Stock" class="form-label">Stock</label>
                <input name="Stock" value="<?= htmlspecialchars($producto['Stock'] ?? '', ENT_QUOTES, 'UTF-8') ?>" type="number" min="0" class="form-control" id="Stock" required>
            </section>

            <section class="col-6 mb-3">
                <label for="Tipo" class="form-label">Tipo</label>
                <input name="Tipo" value="<?= htmlspecialchars($producto['Tipo'] ?? '', ENT_QUOTES, 'UTF-8') ?>" type="text" class="form-control" id="Tipo">
            </section>

            <section class="col-6 mb-3">
                <label for="Marca" class="form-label">Marca</label>
                <input name="Marca" value="<?= htmlspecialchars($producto['Marca'] ?? '', ENT_QUOTES, 'UTF-8') ?>" type="text" class="form-control" id="Marca">
            </section>

            <section class="col-6 mb-3">
                <label for="FechaVencimiento" class="form-label">Fecha de vencimiento</label>
                <input name="FechaVencimiento" value="<?= htmlspecialchars($producto['FechaVencimiento'] ?? '', ENT_QUOTES, 'UTF-8') ?>" type="date" class="form-control" id="FechaVencimiento">
            </section>

            <section class="col-6 mb-3">
                <label for="IdProveedor" class="form-label">Proveedor</label>
                <select name="IdProveedor" id="IdProveedor" class="form-select" required>
                    <option value="">Seleccione un proveedor</option>
                    <?php foreach ($proveedores as $proveedor): ?>
                        <option value="<?= htmlspecialchars($proveedor['Id']) ?>" <?= (($producto['IdProveedor'] ?? '') == $proveedor['Id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($proveedor['Nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </section>

            <section class="col-12 mb-3">
                <button name="boton" class="btn btn-success" type="submit">Modificar producto</button>
            </section>

            <section class="col-12 mb-3">
                <a href="./ListarProducto.php" class="btn btn-danger" role="button">Salir</a>
            </section>
        </main>
    </form>
</div>

</body>
</html>
