<?php
require_once "../../php/config.php";
require_once "../../php/Proveedor.php";

VerificarSesion();

$proveedorModel = new Proovedor();
$busqueda = trim($_GET["Busqueda"] ?? "");
$proveedores = $proveedorModel->ListarProveedor($busqueda);

if (isset($_POST["boton"])) {
    $idProveedor = (int)($_POST["Id"] ?? 0);
    $proveedor = new Proovedor($idProveedor);
    $proveedorConsultado = $proveedor->ConsultarProveedor();

    if ($proveedorConsultado !== false) {
        $_SESSION["Proveedor"] = $proveedorConsultado;
        header("Location: ModificarProveedor.php");
        exit();
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
    <title>Proveedores</title>
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
    <form method="get" class="row align-items-center mb-3">
        <section class="col-12 col-md-3 mb-2">
            <a class="btn btn-primary" href="./ListaProveedor.php">Limpiar</a>
        </section>
        <div class="col-12 col-md-6 mb-2">
            <div class="input-group mx-auto" style="max-width: 450px;">
                <input type="search" name="Busqueda" class="form-control" placeholder="Buscar proveedor..." value="<?= htmlspecialchars($busqueda, ENT_QUOTES, 'UTF-8') ?>">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
        </div>
        <div class="col-12 col-md-3 text-md-end mb-2">
            <a class="btn btn-success" href="AltaProveedor.php">Agregar proveedor</a>
        </div>
    </form>
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
    <main class="overflow-auto flex-grow-1">
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Modificar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($proveedores === []): ?>
                        <tr><td colspan="4" class="text-center">No se encontraron proveedores.</td></tr>
                    <?php else: ?>
                        <?php foreach ($proveedores as $proveedor): ?>
                            <tr>
                                <td><?= htmlspecialchars($proveedor["Id"], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($proveedor["Nombre"], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($proveedor["Telefono"], ENT_QUOTES, 'UTF-8') ?></td>
                                <td>
                                    <form action="" method="post">
                                        <input type="hidden" name="Id" value="<?= htmlspecialchars($proveedor["Id"], ENT_QUOTES, 'UTF-8') ?>">
                                        <button type="submit" name="boton" class="btn btn-primary">Modificar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>
</html>
