<?php
require_once 'Conexion.php';
class Socio{
private ?int $IdMembresia;
private ?DateTime $FechaDePago;
private ?DateTime $FechaDeCierre;


public function __construct(?int $IdMembresia=null, ?DateTime $FechaDePago=null, ?DateTime $FechaDeCierre=null )
{
  $this->IdMembresia=$IdMembresia;
  $this->FechaDePago=$FechaDePago;
  $this->FechaDeCierre=$FechaDeCierre;
}
public function AltaSocio(int $Ci, int $Mes)
{
    $FechaDeCierre = clone $this->FechaDePago;
    $FechaDeCierre->modify("+{$Mes} months");

    $sql = "INSERT INTO socio (FechaDePago, FechaDeCierre, CiUsuario)
            VALUES (?, ?, ?)";

    $conn = new Conexion();
    $db = $conn->establecer_conexion();

    try {
        $consulta = $db->prepare($sql);

        $consulta->execute([
            $this->FechaDePago->format("Y-m-d"),
            $FechaDeCierre->format("Y-m-d"),
            $Ci
        ]);

        echo "Socio agregado correctamente";

    } catch (\PDOException $e) {
        echo "ERROR: " . $e->getMessage();
    }
}

public function ListarSocio(){

    $conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();

    $sql = "SELECT
            socio.IdMembresia,
            usuario.Ci,
            usuario.Nombre,
            usuario.Apellido,
            socio.FechaDePago,
            socio.FechaDeCierre
        FROM usuario
        INNER JOIN socio ON usuario.Ci = socio.CiUsuario";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $Socios= $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $Socios;
}

public function BuscarSocios(string $busqueda, string $Filtro): array
{
    $conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();

    $sql = "SELECT
                socio.IdMembresia,
                usuario.Ci,
                usuario.Nombre,
                usuario.Apellido,
                socio.FechaDePago,
                socio.FechaDeCierre
            FROM usuario
            INNER JOIN socio ON usuario.Ci = socio.CiUsuario
            WHERE (
                usuario.Ci LIKE ?
                OR usuario.Nombre LIKE ?
                OR usuario.Apellido LIKE ?
                OR socio.IdMembresia LIKE ?
                OR socio.FechaDePago LIKE ?
                OR socio.FechaDeCierre LIKE ?
            )";

    if ($Filtro === "Cerca") {
        $sql .= " ORDER BY socio.FechaDeCierre ASC";
    } elseif ($Filtro === "Lejos") {
        $sql .= " ORDER BY socio.FechaDeCierre DESC";
    } elseif ($Filtro === "Vencidos") {
        $sql .= " AND socio.FechaDeCierre < CURDATE()";
    }

    $statement = $pdo->prepare($sql);

    $texto = "%" . $busqueda . "%";

    $statement->execute([
        $texto,
        $texto,
        $texto,
        $texto,
        $texto,
        $texto
    ]);

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}


public function EliminarSocio(){
    $conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();
    $sql = "DELETE FROM socio WHERE IdMembresia=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$this->IdMembresia]);
}
public function ConsultarSocio()
{
    $conexion = new Conexion();

    $pdo = $conexion->establecer_conexion();

   $sql = "SELECT * FROM socio WHERE IdMembresia = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$this->IdMembresia]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function ActualizarFechaCierre()
{
    $conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();

    $sql = "UPDATE socio
            SET FechaDeCierre = ?
            WHERE IdMembresia = ?";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        $this->FechaDeCierre->format("Y-m-d"),
        $this->IdMembresia
    ]);
}
}