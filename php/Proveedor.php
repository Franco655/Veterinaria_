<?php
require_once 'Conexion.php';
class Proovedor{

private ?int $Id;
private ?string $Nombre;
private  ?string $Telefono;


public function __construct(?int $Id=null, ?string $Nombre=null, ?string $Telefono=null)
{
$this->Id=$Id;
$this->Nombre=$Nombre;
$this->Telefono=$Telefono;
}
public function AltaProveedor(): bool
{
    $sql = "INSERT INTO proveedor (Nombre,Telefono) VALUES (?,?)";
    $conn = new Conexion();
    $db = $conn->establecer_conexion();
    $consulta = $db->prepare($sql);
    return $consulta->execute([
        $this->Nombre,
        $this->Telefono
    ]);
}

public function EliminarProveedor(): bool
{
 $conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();
    $sql = "DELETE FROM proveedor WHERE Id=?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$this->Id]);
}
public function ModificarProveedor(): bool
{
    $conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();

    $sql = "UPDATE proveedor
            SET Nombre = ?,
                Telefono = ?
            WHERE Id = ?";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        $this->Nombre,
        $this->Telefono,
        $this->Id
    ]);
}

public function ListarProveedor(string $busqueda = ""): array
{
    $conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();

    $sql = "SELECT Id, Nombre, Telefono FROM proveedor";
    if ($busqueda !== "") {
        $sql .= " WHERE Id LIKE ? OR Nombre LIKE ? OR Telefono LIKE ?";
        $texto = "%" . $busqueda . "%";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$texto, $texto, $texto]);
    } else {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function BuscarProveedor(string $busqueda): array
{
    return $this->ListarProveedor($busqueda);
}

public function ConsultarProveedor(){

    $conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();

    $sql = "SELECT Id, Nombre, Telefono
            FROM proveedor
            WHERE Id = ?";


    $stmt = $pdo->prepare($sql);
    $stmt->execute([$this->Id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
}

