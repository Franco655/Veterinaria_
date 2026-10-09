<?php
require_once 'Conexion.php';
class Producto{
    private ?int $Id;
    private ?string $Nombre;
    private ?string $Descripción;
    private ?float $Precio;
    private ?int $Stock;
    private ?string $Tipo;
    private ?string $Marca;
    private ?DateTime $FechaVencimiento;

    public function __construct(?int $Id=null,?string $Nombre=null,?string $Descripción=null,?float $Precio=null,?int $Stock=null, ?string $Tipo=null,
    ?string $Marca=null, ?DateTime $FechaVencimiento=null )
    {
$this->Id=$Id;
$this->Nombre=$Nombre;
$this->Descripción=$Descripción;
$this->Precio=$Precio;
$this->Stock=$Stock;
$this->Tipo=$Tipo;
$this->Marca=$Marca;
$this->FechaVencimiento=$FechaVencimiento;
    }
public function AltaProducto( string $IdProovedor){
      $sql = "INSERT INTO producto (Nombre, Descripcion, Precio, Stock, Tipo, Marca, FechaVencimiento, IdProveedor) VALUES (?,?,?,?,?,?,?,?)";
    $conn = new Conexion();
    $db = $conn->establecer_conexion();
    try {
        $consulta = $db->prepare($sql);
        $fecha = $this->FechaVencimiento instanceof DateTime
            ? $this->FechaVencimiento->format('Y-m-d')
            : $this->FechaVencimiento;

        $consulta->execute([
            $this->Nombre,
            $this->Descripción,
            $this->Precio,
            $this->Stock,
            $this->Tipo,
            $this->Marca,
            $fecha,
            $IdProovedor
        ]);

    } catch (\PDOException $e) {
    }
    }
 public function EliminarProducto(){
    $conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();
    $sql = "DELETE FROM producto WHERE Id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$this->Id]);
}


public function ModificarProducto(): bool
{
    $conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();

    $sql = "UPDATE producto
            SET Nombre = ?,
                Descripcion = ?,
                Precio = ?,
                Stock = ?,
                Tipo = ?,
                Marca = ?,
                FechaVencimiento = ?
            WHERE Id = ?";

    $stmt = $pdo->prepare($sql);
    $fecha = $this->FechaVencimiento instanceof DateTime
        ? $this->FechaVencimiento->format('Y-m-d')
        : $this->FechaVencimiento;

    return $stmt->execute([
        $this->Nombre,
        $this->Descripción,
        $this->Precio,
        $this->Stock,
        $this->Tipo,
        $this->Marca,
        $fecha,
        $this->Id
    ]);
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
            LEFT JOIN proveedor ON producto.IdProveedor = proveedor.Id";

    if ($busqueda !== "") {
        $sql .= " WHERE producto.Id LIKE :busqueda
                  OR producto.Nombre LIKE :busqueda
                  OR producto.Descripcion LIKE :busqueda
                  OR producto.Tipo LIKE :busqueda
                  OR producto.Marca LIKE :busqueda
                  OR proveedor.Nombre LIKE :busqueda
                  OR proveedor.Id LIKE :busqueda";

        $texto = "%" . $busqueda . "%";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":busqueda" => $texto]);
    } else {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



public function ConsultarProducto()
{
    $conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();

   $sql = "SELECT * FROM Producto WHERE Id= ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$this->Id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}
}

