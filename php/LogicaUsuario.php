<?php


class Usuario{

private String $Nombre;
private String $Apellido;
private string $Mail;
Private string $Direccion;
private String $Rol;

public function __construct(string $Nombre, string $Apellido,string $Mail, string $Direccion, string $Rol) {
    $this->Nombre=$Nombre;
    $this->Apellido=$Apellido;
    $this->Mail=$Mail;
    $this->Direccion=$Direccion;
    $this->Rol=$Rol;
}








//GETTERS
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
    public function getRol():  string{
        return $this->Rol;
    }

    //SETTERS
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
    public function  setRol(String $Rol): void{
        $this->Rol=strtolower(trim($Rol));
    }

}