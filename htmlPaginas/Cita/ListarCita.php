<?php
require_once "../../php/config.php";
require_once "../../php/Cita.php";
VerificarAdministrador();
$cita = new Cita();
$busqueda = trim($_GET["Busqueda"] ?? "");
$citas = $cita->ListarCitas($busqueda);
if (isset($_POST["botonClose"]))
    {
        CerrarSesion();
        header("Location: ../index.php");
        exit(); }



if (isset($_POST["botonDelete"])) {
    $id = filter_var($_POST["IdDelete"] ?? null, FILTER_VALIDATE_INT);

    if ($id !== false && $id !== null) {
        $citaEliminar = new Cita($id);
        $citaEliminar->EliminarCita();
     }
    header("Location: " . $_SERVER["PHP_SELF"]);
     exit();
}

?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link rel="stylesheet" href="../../css/interfaz.css"><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script><title>Citas</title><link rel="icon" type="image/png" href="../../archivos.img/LogoTransparente.png"></head>
<body class="d-flex flex-column vh-100" style="background-color: #282626; color: #ffffff;">
<header class="mx-0 flex-shrink-0">
<div class="row"><section class="col-12 col-md-4"><h2><?= htmlspecialchars($_SESSION["Nombre"], ENT_QUOTES, "UTF-8") ?></h2><p><?= htmlspecialchars($_SESSION["Rol"], ENT_QUOTES, "UTF-8") ?></p></section><div class="offset-md-4 col-12 col-md-4 d-flex justify-content-md-end align-items-center"><div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">Opciones</button><ul class="dropdown-menu"><li><form method="post"><button name="botonClose" class="dropdown-item" type="submit">Cerrar sesión</button></form></li><li><a class="dropdown-item" href="../index.php">Menu principal</a></li></ul></div></div></div>
<section class="row"><div class="col-12 d-flex justify-content-center align-items-center"><h2>Citas</h2></div></section>
<form method="get" class="row align-items-center"><section class="col-3"><a class="btn btn-primary" href="./ListarCita.php">Limpiar</a></section><div class="col-12 col-md-6 mb-2 mb-md-0"><div class="input-group mx-auto" style="max-width: 450px;"><input type="search" name="Busqueda" class="form-control" placeholder="Buscar..." value="<?= htmlspecialchars($busqueda, ENT_QUOTES, "UTF-8") ?>"><button type="submit" class="btn btn-primary">Buscar</button></div></div><div class="col-12 col-md-3 text-md-end"><a class="btn btn-success" href="./AltaCita.php">Agregar Cita</a></div></form>
</header>
<hr class="m-0">
<div class="d-flex vh-100"><div><ul class="nav flex-column h-100"><li class="nav-item"><a class="nav-link" href="./ListarCita.php">Citas</a></li><li class="nav-item"><a class="nav-link" href="#">Ventas</a></li><li class="nav-item"><a class="nav-link" href="../Socio/ListarSocio.php">Membresías</a></li><li class="nav-item"><a class="nav-link" href="../Mascota/ListarMascota.php">Mascotas</a></li><li class="nav-item"><a class="nav-link" href="#">Alertas</a></li><li class="nav-item"><a class="nav-link" href="../Producto/ListarProducto.php">Productos</a></li><li class="nav-item"><a class="nav-link" href="../Proveedor/ListaProveedor.php">Proveedor</a></li><li class="nav-item"><a class="nav-link" href="../Usuario/ListarUsuario.php">Usuarios</a></li></ul></div><div class="vr"></div>
<main class="overflow-auto flex-grow-1"><div class="table-responsive"><table class="table table-striped table-hover table-bordered align-middle"><thead class="table-dark"><tr><th>Id</th><th>Fecha</th><th>Hora</th><th>CI usuario</th><th>Usuario</th><th>Mascota</th><th>Estado</th><th>Motivo</th><th>Modificar</th><th>Eliminar</th></tr></thead><tbody>
<?php foreach ($citas as $fila): ?><tr><td><?= (int)$fila["IdCita"] ?></td><td><?= htmlspecialchars(date("d/m/Y", strtotime($fila["Fecha"]))) ?></td><td><?= htmlspecialchars(substr($fila["Hora"], 0, 5)) ?></td><td><?= htmlspecialchars($fila["CiUsuario"]) ?></td><td><?= htmlspecialchars($fila["NombreUsuario"]) ?></td><td><?= htmlspecialchars($fila["NombreMascota"]) ?></td><td><?= htmlspecialchars($fila["Estado"]) ?><?= !(bool)$fila["Activo"] ? " (inactiva)" : "" ?></td><td><?= htmlspecialchars($fila["Motivo"]) ?></td><td><a class="btn btn-primary" href="./ModificarCita.php?IdCita=<?= (int)$fila["IdCita"] ?>">Modificar</a></td><td><button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminar" data-id="<?= (int)$fila["IdCita"] ?>" data-motivo="<?= htmlspecialchars($fila["Motivo"], ENT_QUOTES, "UTF-8") ?>">Eliminar</button></td></tr><?php endforeach; ?>
<?php if (!$citas): ?><tr><td colspan="10" class="text-center">No hay citas para mostrar.</td></tr><?php endif; ?></tbody></table></div></main></div>
<div class="modal fade" id="modalEliminar" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Eliminar cita</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body">¿Estás seguro de que querés eliminar esta cita?</div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button><form method="post"><input name="IdDelete" type="hidden" id="IdDelete"><button name="botonDelete" type="submit" class="btn btn-danger">Eliminar</button></form></div></div></div></div>
<script>document.getElementById("modalEliminar").addEventListener("show.bs.modal", function (event) { document.getElementById("IdDelete").value = event.relatedTarget.dataset.id; });</script>
</body></html>
