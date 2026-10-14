<?php
require_once "../php/config.php";
require_once "../php/Usuario.php";
require_once "../php/Login.php";

$datosUsuario = $_SESSION["Usuario"] ?? null;

if (!is_array($datosUsuario) && !empty($_SESSION["Nombre"])) {
    $login = new Login($_SESSION["Nombre"]);
    $datosUsuario = $login->ConsultarUsuario();
    if (is_array($datosUsuario)) {
        $_SESSION["Usuario"] = $datosUsuario;
    }
}

if (!is_array($datosUsuario)) {
    header("Location: ./InicioSesion.php");
    exit();
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
  <title>Mi perfil | Veterinaria Maldonado</title>
  <link rel="icon" type="image/png" href="../archivos.img/LogoTransparente.png">

  <!-- Bootstrap aporta únicamente la grilla responsive y los estilos base. -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
    crossorigin="anonymous">
  <!-- Se reutiliza la identidad visual del panel de usuario. -->
  <link rel="stylesheet" href="../css/PanelDeUsuario.css">
</head>
<body>
  <!-- Encabezado compartido visualmente con el panel de usuario. -->
  <header class="PanelHeader">
    <nav class="navbar" aria-label="Encabezado del perfil">
      <div class="container PanelHeaderContent">
        <div class="PanelHeaderBrand">
          <img
            class="PanelHeaderLogo"
            src="../archivos.img/LogoVeterinaria2-removebg-preview.png"
            alt="Logo de Veterinaria Maldonado">
        </div>

        <div class="PanelHeaderActions">
          <a class="btn PanelHeaderButton" href="./PanelDeUsuario.php">Mi panel</a>
          <a class="btn PanelHeaderButton" href="./index.php">Inicio</a>
          <a class="btn PanelHeaderButton" href="./InicioSesion.php">Cerrar sesión</a>
        </div>
      </div>
    </nav>
  </header>

  <main class="container PerfilContainer" aria-labelledby="PerfilTitle">
    <div class="PerfilIntro">
      <p class="text-uppercase text-success fw-semibold mb-1">Mi espacio</p>
      <h1 class="display-6 fw-bold mb-2">Mi perfil</h1>
      <p class="text-muted mb-0">
        Revisá tus datos personales y de contacto.
      </p>
    </div>

    <!-- El contenido del perfil pertenece directamente al main, sin tarjetas internas. -->
    <div class="PerfilMainHeader">
        <div>
          <p class="PerfilEyebrow mb-1">Cuenta de usuario</p>
          <h2 id="PerfilTitle" class="PerfilName mb-1"><?= $escapar($datosUsuario["Nombre"]) ?> <?= $escapar($datosUsuario["Apellido"]) ?></h2>
          <p class="PerfilUsername mb-0"><?= $escapar($datosUsuario["NombreDeUsuario"]) ?></p>
        </div>
        <span class="PerfilRole"><?= $escapar($datosUsuario["Rol"]) ?></span>
    </div>

    <div class="PerfilDetails">
        <!-- Cada fila representa un atributo que luego podrá venir de la base de datos. -->
        <div class="PerfilDetail">
          <span class="PerfilDetailLabel">Nombre</span>
          <span class="PerfilDetailValue"><?= $escapar($datosUsuario["Nombre"]) ?></span>
        </div>
        <div class="PerfilDetail">
          <span class="PerfilDetailLabel">Apellido</span>
          <span class="PerfilDetailValue"><?= $escapar($datosUsuario["Apellido"]) ?></span>
        </div>
        <div class="PerfilDetail">
          <span class="PerfilDetailLabel">Nombre de usuario</span>
          <span class="PerfilDetailValue"><?= $escapar($datosUsuario["NombreDeUsuario"]) ?></span>
        </div>
        <div class="PerfilDetail">
          <span class="PerfilDetailLabel">Cédula de identidad</span>
          <span class="PerfilDetailValue"><?= $escapar($datosUsuario["Ci"]) ?></span>
        </div>
        <div class="PerfilDetail">
          <span class="PerfilDetailLabel">Correo electrónico</span>
          <span class="PerfilDetailValue"><?= $escapar($datosUsuario["Mail"]) ?></span>
        </div>
        <div class="PerfilDetail">
          <span class="PerfilDetailLabel">Teléfono</span>
          <span class="PerfilDetailValue"><?= $escapar($datosUsuario["Telefono"]) ?></span>
        </div>
        <div class="PerfilDetail">
          <span class="PerfilDetailLabel">Dirección</span>
          <span class="PerfilDetailValue"><?= $escapar($datosUsuario["Direccion"]) ?></span>
        </div>
    </div>

    <!-- El usuario puede editar sus propios datos sin acceder al panel administrativo. -->
    <div class="PerfilActions">
      <a href="./ModificarPerfil.php" class="btn PerfilEditButton">Modificar datos</a>
    </div>

  </main>
</body>
</html>
