<?php
require_once 'Conexion.php';

class cita{
private ?int $id;
private ?DateTime $fecha;
private ?string $Estado;
private ?string $Motivo;
private ?bool $Activo;

public function __construct(?int $id=null, ?DateTime $fecha=null, ?string $Estado=null, ?string $Motivo=null, ?bool $Activo = null){
    $this->id = $id;
    $this->fecha = $fecha;
    $this->Estado = $Estado;
    $this->Motivo = $Motivo;
    $this->Activo = $Activo;
}

public function AltaCita(): bool
{
    $sql = "INSERT INTO cita (fecha, Estado, Motivo, Activo) VALUES (?, ?, ?, ?)";
    $conn = new Conexion();
    $db = $conn->establecer_conexion();
    $consulta = $db->prepare($sql);
    return $consulta->execute([
        $this->fecha->format('Y-m-d H:i:s'),
        $this->Estado,
        $this->Motivo,
        $this->Activo
    ]);
}

public function AltaCitaUsuario(string $ciUsuario, int $idMascota, string $fecha, string $hora, string $motivo): bool
{
    $conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();
    $sql = "INSERT INTO cita (Fecha, Hora, Estado, Motivo, Activo, CiUsuario, IdMascota)
            SELECT ?, ?, 'Pendiente', ?, 1, ?, Id
            FROM mascota
            WHERE Id = ? AND CiUsuario = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$fecha, $hora, $motivo, $ciUsuario, $idMascota, $ciUsuario]);

    return $stmt->rowCount() === 1;
}
public function EliminarCita(): bool
{
    $conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();
    $sql = "DELETE FROM cita WHERE id=?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$this->id]);
}

public function EliminarCitaUsuario(string $ciUsuario): bool
{
    $conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();
    $sql = "DELETE FROM cita WHERE IdCita = ? AND CiUsuario = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$this->id, $ciUsuario]);

    return $stmt->rowCount() === 1;
}

public function ModificarCita(): bool
{
    $conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();

    $sql = "UPDATE cita
            SET fecha = ?,
                Estado = ?,
                Motivo = ?,
                Activo = ?
            WHERE id = ?";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        $this->fecha->format('Y-m-d H:i:s'),
        $this->Estado,
        $this->Motivo,
        $this->Activo,
        $this->id
    ]);


}
public function ListarCitas(): array{

    $conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();
    $sql = "SELECT * FROM cita";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function ListarCitaPorCi(?int $ciUsuario): array{
    $conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();
    $sql = "SELECT * FROM cita WHERE CiUsuario=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$ciUsuario]);
    return $stmt->fetch(PDO::FETCH_ASSOC);

}

public function ListarProximasPorCi(string $ciUsuario): array
{
    $conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();
    $sql = "SELECT
                cita.IdCita,
                cita.Fecha,
                cita.Hora,
                cita.Estado,
                cita.Motivo,
                mascota.Nombre AS NombreMascota
            FROM cita
            INNER JOIN mascota ON mascota.Id = cita.IdMascota
            WHERE cita.CiUsuario = ?
              AND cita.Activo = 1
              AND cita.Fecha >= CURDATE()
            ORDER BY cita.Fecha ASC, cita.Hora ASC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$ciUsuario]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}