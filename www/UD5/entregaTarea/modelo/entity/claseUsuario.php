<?php  

class User{

    //atributos    
    private int $id;
    private string $username;
    private string $name;
    private string $apellidos;
    private string $contrasena;
    private bool $rol;

    //constructor
    function __construct($id, $username, $name, $apellidos, $contrasena, $rol){
        $this-> id = $id;
        $this->username = $username;
        $this->name = $name;
        $this-> apellidos = $apellidos;
        $this->  contrasena = $contrasena;
        $this-> rol = $rol;
    }

    //setters y getters
    function setId($id){
        $this-> id = $id;
    }
    function getId(){
        return $this->id;
    }

    function setUsername($username){
        $this-> username = $username;
    }
    function getUsername(){
        return $this->username;
    }

    function setName($name){
        $this-> name = $name;
    }
    function getName(){
        return $this->name;
    }

    function setApellidos($apellidos){
        $this-> apellidos = $apellidos;
    }
    function getApellidos(){
        return $this->apellidos;
    }

    function setContrasena($contrasena){
        $this-> contrasena = $contrasena;
    }
    function getContrasena(){
        return $this->contrasena;
    }

    function setRol($rol){
        $this-> rol = $rol;
    }
    function getRol(){
        return $this->rol;
    }
}

?>