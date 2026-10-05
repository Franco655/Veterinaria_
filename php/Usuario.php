<?php
require_once 'Conexion.php';

class Usuario{
private ?string $Ci;
private ?string $Nombre;
private ?string $Apellido;
private ?string $Mail;
private ?string $Direccion;
private ?int $Telefono;
private ?string $Rol;
public function __construct(?string $Ci=null, ?string $Nombre=null, ?string $Apellido=null, ?string $Mail=null, ?string $Direccion=null,?int $Telefono=null, ?string $Rol="Usuario") {
    $this->Ci=$Ci;
    $this->Nombre=$Nombre;
    $this->Apellido=$Apellido;
    $this->Mail=$Mail;
    $this->Direccion=$Direccion;
    $this->Telefono=$Telefono;
    $this->Rol=$Rol;
}


public function AltaUsuario()
{
    $sql = "INSERT INTO usuario VALUES (?, ?, ?, ?, ?, ?, ?)";
    $conn = new Conexion();
    $db = $conn->establecer_conexion();
    try {
        $consulta = $db->prepare($sql);
        $consulta->execute([
            $this->Ci,
            $this->Nombre,
            $this->Apellido,
            $this->Direccion,
            $this->Mail,
            $this->Telefono,
            $this->Rol
        ]);

    } catch (\PDOException $e) {
    }
}
public function VerificarCi($Verificar=null): string{
    $conn = new Conexion();
    $db = $conn->establecer_conexion();
//VERIFIACIÓN EN CASE DE REPETIDO QUITANDO EL PROPIO
    if($Verificar !=null){
    $sqlquery="SELECT * FROM usuario WHERE Ci = ? AND Ci != ?";
 $statement = $db->prepare($sqlquery);
    $statement->execute([
        $this->Ci,
        $Verificar
    ]);
     if ($statement->fetchColumn()) {
        return "El ci no ya esta en uso";
    }
    return "";

    }
    // . Verificación previa de cédula repetida
    $sqlquery = "SELECT 1 FROM usuario WHERE Ci = ?";
    $statement = $db->prepare($sqlquery);
    $statement->execute([$this->Ci]);
     if ($statement->fetchColumn()) {
        return "El ci ya esta en uso";
    }
    return "";
}
public function ListarUsuario(){

    $conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();

    $sql = "SELECT
            usuario.Ci,
            usuario.Nombre,
            usuario.Apellido,
            usuario.Mail,
            usuario.Direccion,
            usuario.Telefono,
            usuario.Rol,
            login.NombreDeUsuario
        FROM usuario
        INNER JOIN login ON usuario.Ci = login.CiUsuario";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $usuarios;
}

public function ConsultarUsuario(){

    $conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();

     $sql = "SELECT
            usuario.Ci,
            usuario.Nombre,
            usuario.Apellido,
            usuario.Direccion,
            usuario.Mail,
            usuario.Telefono,
            usuario.Rol,
            login.NombreDeUsuario
        FROM usuario
        INNER JOIN login
            ON usuario.Ci = login.CiUsuario
        WHERE usuario.Ci = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$this->Ci]);

    return $stmt->fetch(PDO::FETCH_ASSOC);

}
public function ModificarUsuario(int $Ci){
$conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();
    $sql = "UPDATE usuario
        SET Ci = ?,
            Nombre = ?,
            Apellido = ?,
            Direccion = ?,
            Mail = ?,
            Telefono = ?,
            Rol = ?
        WHERE Ci = ?";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $this->Ci,
    $this->Nombre,
    $this->Apellido,
    $this->Direccion,
    $this->Mail,
    $this->Telefono,
    $this->Rol,
    $Ci
]);
}

public function EliminarUsuario(){
$conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();
    $sql = "DELETE FROM usuario WHERE Ci=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$this->Ci]);
}
public function BuscarUsuarios(string $busqueda): array
{
    $conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();

    $sql = "SELECT
                usuario.Ci,
                usuario.Nombre,
                usuario.Apellido,
                usuario.Direccion,
                usuario.Mail,
                usuario.Telefono,
                usuario.Rol,
                login.NombreDeUsuario
            FROM usuario
            INNER JOIN login ON usuario.Ci = login.CiUsuario
            WHERE usuario.Ci LIKE :busquedaCi
               OR usuario.Nombre LIKE :busquedaNombre
               OR usuario.Apellido LIKE :busquedaApellido
               OR usuario.Mail LIKE :busquedaMail
               OR login.NombreDeUsuario LIKE :busquedaUsuario";

    $statement = $pdo->prepare($sql);

    $texto = "%" . $busqueda . "%";

    $statement->execute([
        ":busquedaCi" => $texto,
        ":busquedaNombre" => $texto,
        ":busquedaApellido" => $texto,
        ":busquedaMail" => $texto,
        ":busquedaUsuario" => $texto
    ]);

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

public function VerificarGmail(): String{
      $conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();
     $sql = "SELECT 1 FROM usuario WHERE Mail= ?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$this->Mail]);
     if ($statement->fetchColumn()) {
        return "";
    }
    return " No se encontro el mail";

}


//GETTERS
public function getCi(): int{
    return $this->Ci;
}
public function getNombre(): string
    {
        return $this->Nombre;
    }

    public function getApellido(): string{
        return $this->Apellido;
    }
    public function getMail(): String{
        return $this->Mail;
    }
    public function getDireccion(): string{
        return $this->Direccion;
    }
    public function getTelefono(): int{
        return $this->Telefono;
    }
    public function getRol():  string{
        return $this->Rol;
    }

    //SETTERS
    public  function setCi(int $Ci): void{
        $this->Ci=strtolower(trim($Ci));
    }
    public function setNombre(string $Nombre): void
    {
        $this->Nombre = strtolower(trim($Nombre));
    }
    public function setApellido(string $Apellido): void{
    $this->Apellido=strtolower(trim($Apellido));
    }
    public function setMail(string $Mail): void{
    $this->Mail=strtolower(trim($Mail));
    }
    public function setDireccion(string $Direccion){
        $this->Direccion=strtolower(trim($Direccion));
    }
    public function setTelefono(int $Telefono): void{
        $this->Telefono=$Telefono;

    }
    public function  setRol(String $Rol): void{
        $this->Rol=strtolower(trim($Rol));
    }

}