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
        $this->hashpassword = password_hash($this->hashpassword, PASSWORD_DEFAULT);
        $sqlinsert = "INSERT INTO login VALUES (?, ?, ?)";
        $statement = $pdo->prepare($sqlinsert);
        $statement->execute([
            $this->username,
            $this->hashpassword,
            $Ci
        ]);
}




  public function Validar(): string
{
    // 1. Evitamos instanciar la conexión múltiples veces si no es necesario
    $conectar = new Conexion();
    $db = $conectar->establecer_conexion();

    // 2. Buscamos directamente por NombreDeUsuario para evitar conversiones implícitas de tipos en MySQL
    $sqlquery = "SELECT l.Contraseña, u.Rol
                 FROM login l
                 INNER JOIN usuario u ON l.CiUsuario = u.Ci
                 WHERE l.NombreDeUsuario = ?
                 LIMIT 1"; // LIMIT 1 le dice al motor que se detenga apenas encuentre al usuario

    try {
        $statement = $db->prepare($sqlquery);
        $statement->execute([$this->username]);

        // 3. Usamos FETCH_ASSOC para liberar memoria y traer solo lo necesario
        $usuarioEncontrado = $statement->fetch(PDO::FETCH_ASSOC);

        if ($usuarioEncontrado) {

            if (password_verify($this->hashpassword, $usuarioEncontrado["Contraseña"])) {
                return $usuarioEncontrado["Rol"];
            }
        }
    } catch (PDOException $e) {
        // Opcional: Puedes registrar el error en un log (error_log($e->getMessage());)
        return "";
    }

    return "";
}


 public function VerificarUsuario($Verificar=null): string{
    $conectar = new Conexion();
    $pdo = $conectar->establecer_conexion();
    if($Verificar !=null){
    $sqlquery="SELECT * FROM login WHERE NombreDeUsuario = ? AND NombreDeUsuario != ?";
 $statement = $pdo->prepare($sqlquery);
    $statement->execute([
        $this->username,
        $Verificar
    ]);
     if ($statement->fetchColumn()) {
        return "El Usuario ya esta en uso";
    }
    return "";

    }
    $sqlquery = "SELECT 1 FROM login WHERE NombreDeUsuario = ?";
    $statementCheck = $pdo->prepare($sqlquery);
    $statementCheck->execute([$this->username]);
    if ($statementCheck->fetchColumn()) {
        return "El Usuario ya esta usado";
    }
    return "";
 }

 public function ModificarLogin(int $Ci)
{
    $conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();
    $sql = "UPDATE login
            SET NombreDeUsuario = ?
            WHERE CiUsuario = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $this->username,
        $Ci
    ]);
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
