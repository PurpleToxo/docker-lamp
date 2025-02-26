<?php
class DatabaseException extends Exception{

    //atributos method y sql
    private $method;
    private $sql;

    function __construct($message, $method, $sql, $codigo = 0, Exception $anterior = null){
        parent :: __construct ($message, $codigo, $anterior); //preguntar si es igual a super
        $this->method = $method;
        $this->sql = $sql;
    }
    function getMethod(){
        return $this->method;
    }
    function getSQL(){
        return $this->sql;
    }
    
}


?>