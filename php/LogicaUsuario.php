<?php
require_once 'Conexion.php';

class Usuario{
private int $Ci;
private String $Nombre;
private String $Apellido;
private string $Mail;
Private string $Direccion;
private int $Telefono;
private String $Rol;

public function __construct(int $Ci,string $Nombre, string $Apellido,string $Mail, string $Direccion,int $Telefono, ?string $Rol) {
    $this->Ci=$Ci;
    $this->Nombre=$Nombre;
    $this->Apellido=$Apellido;
    $this->Mail=$Mail;
    $this->Direccion=$Direccion;
    $this->Telefono=$Telefono;
    $this->Rol=$Rol;
}


function AltaUsuario()
{
    $conn = new Conexion();
   $sql = "INSERT INTO usuario VALUES (?, ?, ?, ?,?,?,?)";
    $consulta = $conn->establecer_conexion()->prepare($sql);
    $success = $consulta->execute([
        $this->Ci,
        $this->Nombre,
        $this->Apellido,
        $this->Direccion,
        $this->Mail,
        $this->Telefono,
        $this->Rol
    ]);

    if ($success) {
    } else {
        echo "algo salio malo";
    }
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