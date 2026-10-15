<?php
require_once 'Conexion.php';

class cita{
private ?int $id;
private ?DateTime $fecha;
private ?string $hora;
private ?string $Estado;
private ?string $Motivo;
private ?bool $Activo;


public function __construct(?int $id = null, ?DateTime $fecha = null, ?string $Estado = null,
    ?string $Motivo = null,
    ?bool $Activo = null,
    ?string $hora = null
){
    $this->id = $id;
    $this->fecha = $fecha;
    $this->hora = $hora;
    $this->Estado = $Estado;
    $this->Motivo = $Motivo;
    $this->Activo = $Activo;
}

public function AltaCitaUsuario(string $ciUsuario, int $idMascota): bool
{
    if ($this->fecha === null || $this->hora === null || $this->Motivo === null) {
        return false;
    }

    $conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();
    $sql = "INSERT INTO cita (Fecha, Hora, Estado, Motivo, Activo, CiUsuario, IdMascota)
            SELECT ?, ?, ?, ?, ?, ?, Id
            FROM mascota
            WHERE Id = ? AND CiUsuario = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $this->fecha->format("Y-m-d"),
        $this->hora,
        $this->Estado ?? "Pendiente",
        $this->Motivo,
        $this->Activo ?? true,
        $ciUsuario,
        $idMascota,
        $ciUsuario
    ]);

    return $stmt->rowCount() === 1;
}
public function EliminarCita(?string $ciUsuario = null): bool
{
    $conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();
    $sql = "DELETE FROM cita WHERE IdCita = ?";
    $parametros = [$this->id];

    if ($ciUsuario !== null) {
        $sql .= " AND CiUsuario = ?";
        $parametros[] = $ciUsuario;
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($parametros);
    return $stmt->rowCount() === 1;
}

public function ModificarCita(): bool
{
    $conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();

    $sql = "UPDATE cita
            SET Fecha = ?,
                Estado = ?,
                Motivo = ?,
                Activo = ?
            WHERE IdCita = ?";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        $this->fecha->format('Y-m-d'),
        $this->Estado,
        $this->Motivo,
        $this->Activo,
        $this->id
    ]);


}
public function ListarCitas(string $busqueda = ""): array{

    $conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();
    $sql = "SELECT cita.IdCita, cita.Fecha, cita.Hora, cita.Estado, cita.Motivo,
                   cita.Activo, cita.CiUsuario, cita.IdMascota,
                   CONCAT(usuario.Nombre, ' ', usuario.Apellido) AS NombreUsuario,
                   mascota.Nombre AS NombreMascota
            FROM cita
            INNER JOIN usuario ON usuario.Ci = cita.CiUsuario
            INNER JOIN mascota ON mascota.Id = cita.IdMascota";
    if ($busqueda !== "") {
        $sql .= " WHERE cita.IdCita LIKE ?
                   OR cita.CiUsuario LIKE ?
                   OR usuario.Nombre LIKE ?
                   OR usuario.Apellido LIKE ?
                   OR mascota.Nombre LIKE ?
                   OR cita.Estado LIKE ?";
        $texto = "%{$busqueda}%";
        $stmt = $pdo->prepare($sql . " ORDER BY cita.Fecha ASC, cita.Hora ASC");
        $stmt->execute([$texto, $texto, $texto, $texto, $texto, $texto]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    $sql .= " ORDER BY cita.Fecha ASC, cita.Hora ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function ListarCitaPorCi(?string $ciUsuario): array{
    $conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();
    $sql = "SELECT * FROM cita WHERE CiUsuario=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$ciUsuario]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

public function ConsultarCita(): ?array
{
    $conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();
    $sql = "SELECT IdCita, Fecha, Hora, Estado, Motivo, Activo, CiUsuario, IdMascota
            FROM cita WHERE IdCita = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$this->id]);
    $cita = $stmt->fetch(PDO::FETCH_ASSOC);
    return $cita ?: null;
}





public function ListarUsuariosParaCita(): array
{
    $conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();
    $stmt = $pdo->query("SELECT Ci, Nombre, Apellido FROM usuario ORDER BY Nombre, Apellido");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function ListarMascotasParaCita(): array
{
    $conexion = new Conexion();
    $pdo = $conexion->establecer_conexion();
    $stmt = $pdo->query("SELECT mascota.Id, mascota.Nombre, mascota.CiUsuario,
                                usuario.Nombre AS NombreUsuario,
                                usuario.Apellido AS ApellidoUsuario
                         FROM mascota
                         INNER JOIN usuario ON usuario.Ci = mascota.CiUsuario
                         ORDER BY usuario.Nombre, usuario.Apellido, mascota.Nombre");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
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