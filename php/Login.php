<?php
require_once 'Conexion.php';
class Login
{

    private ?string $username;
    private ?string $hashpassword;

    public function __construct(?string $username = null, ?string $hashpassword = null)
    {
        $this->username = $username;
        $this->hashpassword = $hashpassword;
    }


    public function AltaLogin(int $Ci)
{
    $conectar = new Conexion();
    $pdo = $conectar->establecer_conexion();
    try {
        $this->hashpassword = password_hash($this->hashpassword, PASSWORD_DEFAULT);
        $sqlinsert = "INSERT INTO login VALUES (?, ?, ?)";
        $statement = $pdo->prepare($sqlinsert);
        $statement->execute([
            $this->username,
            $this->hashpassword,
            $Ci
        ]);

        return "";

    } catch (\PDOException $e) {
        return "Hubo un error en el programa: " . $e->getMessage();
    }
}




     public function Validar(): bool
{
    $conectar = new Conexion();
    $sqlquery = "SELECT NombreDeUsuario, Contraseña FROM login WHERE NombreDeUsuario = ?";
    $statement = $conectar->establecer_conexion()->prepare($sqlquery);
    $statement->execute([$this->username]);
    $usuarioEncontrado = $statement->fetch();

    if ($usuarioEncontrado) {
        // Pasa la contraseña tal cual la ingresó el usuario
        if (password_verify($this->hashpassword, $usuarioEncontrado["Contraseña"])) {
            return true; // Credenciales correctas
        }
    }

    return false; // Usuario no existe o contraseña incorrecta
}

 public function VerificarUsuario(): string{
    $conectar = new Conexion();
    $pdo = $conectar->establecer_conexion();
    $sqlquery = "SELECT 1 FROM login WHERE NombreDeUsuario = ?";
    $statementCheck = $pdo->prepare($sqlquery);
    $statementCheck->execute([$this->username]);
    if ($statementCheck->fetchColumn()) {
        return "El Usuario ya esta usado";
    }
    return "";
 }


    //GETTERS
    public function getUsername(): string
    {
        return $this->username;
    }
    public function gethashpassword(): string
    {
        return $this->hashpassword;
    }

    //SETTERS
    public function setUsername(string $username): void
    {
        $this->username = strtolower(trim($username));
    }
    public function setHashpassword(string $hashpassword): void
    {
        $this->hashpassword = strtolower(trim($hashpassword));
    }
}
