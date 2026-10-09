<?php

require_once 'Conexion.php';

class Mascota{

    private ?int $Id;
    private ?string $Raza;
    private ?string $Nombre;
    private ?DateTime $Nacimiento;
    private ?bool $Castrado;
    private ?float $Peso;

    public function __construct(?int $Id = null,?string $Raza = null,?string $Nombre = null,?DateTime $Nacimiento = null,?bool $Castrado = null,?float $Peso = null
    ) {
        $this->Id = $Id;
        $this->Raza = $Raza;
        $this->Nombre = $Nombre;
        $this->Nacimiento = $Nacimiento;
        $this->Castrado = $Castrado;
        $this->Peso = $Peso;
    }


    public function AltaMascota( string $Ci){
      $sql = "INSERT INTO mascota (Raza, Nombre, FechaNacimiento, Castrado, Peso, CiUsuario) VALUES (?, ?, ?, ?, ?, ?)";
    $conn = new Conexion();
    $db = $conn->establecer_conexion();
    try {
        $consulta = $db->prepare($sql);
        $consulta->execute([
            $this->Raza,
            $this->Nombre,
            $this->Nacimiento->format("Y-m-d"),
            $this->Castrado,
            $this->Peso,
            $Ci
        ]);

    } catch (\PDOException $e) {
    }
    }
    public function ListarMascota(){
 $conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();

   $sql = "SELECT
            mascota.Id,
            usuario.Ci,
            usuario.Nombre AS Dueño,
            mascota.Nombre AS Nombre,
            mascota.FechaNacimiento,
            mascota.Castrado,
            mascota.Peso
        FROM usuario
        INNER JOIN mascota ON usuario.Ci = mascota.CiUsuario";

$stmt = $pdo->prepare($sql);
$stmt->execute();

$Mascotas = $stmt->fetchAll(PDO::FETCH_ASSOC);

return $Mascotas;
    }

public function BuscarMascota(string $busqueda): array
{
    $conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();

    $sql = "SELECT
                mascota.Id,
                usuario.Ci,
                usuario.Nombre AS Dueño,
                mascota.Nombre,
                mascota.FechaNacimiento,
                mascota.Castrado,
                mascota.Peso
            FROM usuario
            INNER JOIN mascota ON usuario.Ci = mascota.CiUsuario
            WHERE mascota.Id LIKE ?
               OR usuario.Ci LIKE ?
               OR usuario.Nombre LIKE ?
               OR mascota.Nombre LIKE ?";

    $stmt = $pdo->prepare($sql);

    $texto = "%" . $busqueda . "%";

    $stmt->execute([
        $texto,
        $texto,
        $texto,
        $texto
    ]);

    $Mascotas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $Mascotas;
}

    public function EliminarMascota(){
    $conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();
    $sql = "DELETE FROM mascota WHERE Id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$this->Id]);
}
public function ModificarMascota( string $Ci)
{
    $conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();

    $sql = "UPDATE mascota
            SET Nombre = ?,
            SET Raza = ?,
            SET FechaNacimiento = ?,
             SET FechaNacimiento = ?,
             SET Castrado = ?
             SET Peso = ?
              SET CiUsuario = ?
            WHERE Id= ?";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        $this->Nombre,
        $this->Raza,
        $this->Nacimiento,
        $this->Castrado,
        $this->Peso,
        $Ci
    ]);
}
public function  ConsultarMascota(){

    $conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();
$sql = "SELECT Id, Raza, Nombre, FechaNacimiento, Castrado, Peso FROM mascota WHERE Id = ?";




    $stmt = $pdo->prepare($sql);
    $stmt->execute([$this->Id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}


public function ListarProducto(string $busqueda = ""): array
{
    $conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();

    $sql = "SELECT
                producto.Id,
                producto.Nombre,
                producto.Descripcion,
                producto.Precio,
                producto.Stock,
                producto.Tipo,
                producto.Marca,
                producto.FechaVencimiento,
                proveedor.Id AS IdProveedor,
                proveedor.Nombre AS NombreProveedor
            FROM producto
            INNER JOIN proveedor
                ON producto.IdProveedor = proveedor.Id";

    if ($busqueda != "") {
        $sql .= " WHERE producto.Id LIKE ?
                  OR producto.Nombre LIKE ?
                  OR producto.Descripcion LIKE ?
                  OR producto.Tipo LIKE ?
                  OR producto.Marca LIKE ?
                  OR proveedor.Id LIKE ?
                  OR proveedor.Nombre LIKE ?";

        $busqueda = "%$busqueda%";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $busqueda,
            $busqueda,
            $busqueda,
            $busqueda,
            $busqueda,
            $busqueda,
            $busqueda
        ]);
    } else {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}