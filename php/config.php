
<?php
session_start();

function CerrarSesion() {

    // 1. Limpiar las variables de sesión
    $_SESSION = [];

    // 2. Destruir la cookie de sesión
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();

        setcookie(session_name(), '', [
            'expires' => time() - 3600,
            'path' => $params["path"],
            'domain' => $params["domain"],
            'secure' => $params["secure"],
            'httponly' => $params["httponly"],
            'samesite' => 'Strict'
        ]);
    }

    // 3. Destruir la sesión en el servidor
    session_destroy();
}

function VerificarAdministrador(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (
        !isset($_SESSION["Nombre"], $_SESSION["Rol"]) ||
        $_SESSION["Rol"] !== "Administrador"
    ) {
        header("Location: ../index.php");
        exit();
    }
}

function VerificarSesion(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (
        !isset($_SESSION["Nombre"], $_SESSION["Rol"]) ||
        $_SESSION["Rol"] === "Usuario"
    ) {
        header("Location: ../index.php");
        exit();
    }
}