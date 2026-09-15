<?php
require_once 'Conexion.php';
class Login
{

    private ?string $username;
    private ?string $hashpassword;

    public function __construct(?string $username = null, ?string $hashpassword = null)
    {
        $this->username = $username;
        $this->hashpassword = $hashpassword;
    }


    public function AltaLogin(int $Ci)
    {
        $conectar = new Conexion();
            $this->hashpassword = password_hash($this->hashpassword, PASSWORD_DEFAULT);
            $sqlinsert = "INSERT INTO login VALUES (?,?,?)";
            $statement = $conectar->establecer_conexion()->prepare($sqlinsert);
            if ($statement->execute([
                $this->username,
            $this->hashpassword,
            $Ci
            ]))
            {

                return true;
            } else {
            }

        }



     public function Validar(): bool
    {
        $conectar = new Conexion();
        //el passord se resalta en azul porque el el editor lo detecta como una función
        $sqlquery = "SELECT NombreDeUsuario, Contraseña FROM login WHERE NombreDeUsuario= ?";
        $statement = $conectar->establecer_conexion()->prepare($sqlquery);
        $statement->execute([$this->username]);
        $usuarioEncontrado = $statement->fetch();

        if ($usuarioEncontrado == true) {
            if(password_verify($this->hashpassword, $usuarioEncontrado["Contraseña"])){
                return true;
            }
        }
        return false;
    }


    //GETTERS
    public function getUsername(): string
    {
        return $this->username;
    }
    public function gethashpassword(): string
    {
        return $this->hashpassword;
    }

    //SETTERS
    public function setUsername(string $username): void
    {
        $this->username = strtolower(trim($username));
    }
    public function setHashpassword(string $hashpassword): void
    {
        $this->hashpassword = strtolower(trim($hashpassword));
    }
}
