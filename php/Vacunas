<?php
require_once 'Conexion.php';

class Vacuna{
    private ?int $id;
    private ?string $nombre;
    private ?string $descripcion;
    private ?datetime $FechaAplicacion;
    private ?datetime $FechaVencimiento;


    public function __construct(?int $id=null, ?string $nombre=null, ?string $descripcion=null, ?datetime $FechaAplicacion=null, ?datetime $FechaVencimiento=null){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->FechaAplicacion = $FechaAplicacion;
        $this->FechaVencimiento = $FechaVencimiento;
    }
 public function ListarVacunasPorMascota(int $idMascota): array{
        $conexion = new Conexion();
        $pdo = $conexion->establecer_conexion();

        $sql = "SELECT
                    Id,
                    Nombre,
                    FechaDeVacunacion,
                    FechaDeVencimiento,
                    IdMascota
                FROM vacunas
                WHERE IdMascota = ?
                ORDER BY FechaDeVencimiento ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idMascota]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

    public function ListarProximasPorCi(string $ciUsuario, int $dias = 30): array
    {
        $conexion = new Conexion();
        $pdo = $conexion->establecer_conexion();

        $dias = max(1, $dias);
        $fechaLimite = (new DateTimeImmutable())->modify("+{$dias} days")->format("Y-m-d");
        $sql = "SELECT
                    vacunas.Id,
                    vacunas.Nombre,
                    vacunas.FechaDeVencimiento,
                    mascota.Nombre AS NombreMascota
                FROM vacunas
                INNER JOIN mascota ON mascota.Id = vacunas.IdMascota
                WHERE mascota.CiUsuario = ?
                  AND vacunas.FechaDeVencimiento BETWEEN CURDATE() AND ?
                ORDER BY vacunas.FechaDeVencimiento ASC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$ciUsuario, $fechaLimite]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

    public function getId(){
        return $this->id;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getDescripcion(){
        return $this->descripcion;
    }

    public function getFechaAplicacion(){
        return $this->FechaAplicacion;
    }

    public function getFechaVencimiento(){
        return $this->FechaVencimiento;
    }
}