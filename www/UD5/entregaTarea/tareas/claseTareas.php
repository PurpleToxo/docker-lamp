<?php
class Tarea{

    //atributos
    private $id;
    private $titulo;
    private $descripcion;
    private $estado;
    private $usuario;

    //constructor
    function __constructor($id,$titulo,$descripcion,$estado,$usuario){
        $this-> id = $id;
        $this->titulo=$titulo;
        $this->descripcion=$descripcion;
        $this->estado=$estado;
        $this->usuario=$usuario;
    }

    //setters y getters
    function setId($id){
        $this->id=$id;
    }
    function getId(){
        return $this->id;
    }

    function setTitulo($titulo){
        $this->titulo=$titulo;
    }
    function getTitulo(){
        return $this->titulo;
    }

    function setDescripcion($descripcion){
        $this->descripcion=$descripcion;
    }
    function getDescripcion(){
        return $this->descripcion;
    }

    function setEstado($estado){
        $this->estado=$estado;
    }
    function getEstado(){
        return $this->estado;
    }

    function setUsuario($usuario){
        $this->usuario=$usuario;
    }
    function getUsuario(){
        return $this->usuario;
    }

}
?>