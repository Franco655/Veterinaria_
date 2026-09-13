<?php

class Conexion
{

    private $dsn = "mysql:host=localhost;dbname=veterinaria;charset=utf8mb4";
    private $usuarioDb = "root";
    private $passwordDb = "";
    private ?PDO $pdo = null;
    public function establecer_conexion(): PDO
    {
        if ($this->pdo !== null) {
            return $this->pdo;
        }
        try {
            $this->pdo = new PDO(
                $this->dsn,
                $this->usuarioDb,
                $this->passwordDb
            );
            return $this->pdo;
        } catch (PDOException $e) {
            throw new PDOException(
                "Error de conexión a la base de datos: " . $e->getMessage()
            );
        }
    }
}
